<?php

namespace App\Http\Controllers;

use App\Models\Saldo;
use App\Models\Bukti;
use App\Models\Tahun;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SaldoAwalPrintController extends Controller
{
    public function print(Request $request)
    {
        // Ambil parameter tahun dari request, default ke tahun saat ini
        $tahunId = $request->get('tahun_id');
        $tanggalMulai = $request->get('tanggal_mulai');
        $tanggalSampai = $request->get('tanggal_sampai');
        $currentYear = date('Y');

        // Jika tidak ada tahun_id, cari tahun saat ini
        if (!$tahunId) {
            $tahunSaatIni = Tahun::where('tahun', $currentYear)->first();
            $tahunId = $tahunSaatIni ? $tahunSaatIni->id : null;
        }

        // Ambil data tahun
        $tahun = Tahun::find($tahunId);
        $tahunText = $tahun ? $tahun->tahun : $currentYear;

        // Query data saldo dengan relasi level3 dan filter tahun
        $saldoData = Saldo::with(['level3', 'tahun'])
            ->when($tahunId, function ($query) use ($tahunId) {
                return $query->where('tahun_id', $tahunId);
            })
            ->whereNotNull('level3_id')
            ->orderBy('level3_id')
            ->get()
            ->groupBy('level3.nama');

        // Query data bukti dengan relasi dan filter tanggal
        $buktiData = Bukti::with([
            'anggaranDetailItem.anggaran.level1',
            'anggaranDetailItem.anggaran.level2',
            'anggaranDetailItem.anggaran.level3'
        ])
            ->when($tanggalMulai && $tanggalSampai, function ($query) use ($tanggalMulai, $tanggalSampai) {
                return $query->whereBetween('tanggal', [$tanggalMulai, $tanggalSampai]);
            })
            ->when(!$tanggalMulai && !$tanggalSampai && $tahunId && $tahun, function ($query) use ($tahun) {
                return $query->whereYear('tanggal', $tahun->tahun);
            })
            ->orderBy('tanggal', 'desc')
            ->limit(50) // Batasi untuk performa
            ->get();

        // Query terpisah untuk menghitung total pemasukan dan pengeluaran
        $baseQuery = Bukti::query()
            ->when($tanggalMulai && $tanggalSampai, function ($query) use ($tanggalMulai, $tanggalSampai) {
                return $query->whereBetween('tanggal', [$tanggalMulai, $tanggalSampai]);
            })
            ->when(!$tanggalMulai && !$tanggalSampai && $tahunId && $tahun, function ($query) use ($tahun) {
                return $query->whereYear('tanggal', $tahun->tahun);
            });

        // Hitung total pemasukan (3 digit pertama nomor = 'PEN')
        $totalPemasukan = (clone $baseQuery)->where('nomor', 'LIKE', 'PEN%')->sum('jumlah');

        // Hitung total pengeluaran (3 digit pertama nomor = 'BEL')
        $totalPengeluaran = (clone $baseQuery)->where('nomor', 'LIKE', 'BEL%')->sum('jumlah');

        // Hitung total saldo per jenis kas
        $totalSaldoPerJenis = [];
        foreach ($saldoData as $jenisKas => $saldos) {
            $totalSaldoPerJenis[$jenisKas] = $saldos->sum('jumlah');
        }

        // Hitung grand total saldo
        $grandTotalSaldo = array_sum($totalSaldoPerJenis);

        // Tentukan periode untuk judul laporan
        $periode = '';
        if ($tanggalMulai && $tanggalSampai) {
            $periode = \Carbon\Carbon::parse($tanggalMulai)->isoFormat('DD MMMM YYYY') . ' - ' . \Carbon\Carbon::parse($tanggalSampai)->isoFormat('DD MMMM YYYY');
        } else {
            $periode = 'Tahun ' . $tahunText;
        }

        // Data untuk view
        $data = [
            'tahun' => $tahunText,
            'periode' => $periode,
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_sampai' => $tanggalSampai,
            'tanggal_cetak' => now()->format('d/m/Y H:i:s'),
            'saldo_data' => $saldoData,
            'bukti_data' => $buktiData,
            'total_saldo_per_jenis' => $totalSaldoPerJenis,
            'grand_total_saldo' => $grandTotalSaldo,
            'total_pemasukan' => $totalPemasukan,
            'total_pengeluaran' => $totalPengeluaran,
            'saldo_akhir' => $grandTotalSaldo + $totalPemasukan - $totalPengeluaran
        ];

        // Generate PDF
        $pdf = Pdf::loadView('report.saldo-kas', $data)
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'DejaVu Sans',
                'isFontSubsettingEnabled' => true,
                'chroot' => public_path(),
            ]);

        return $pdf->stream('posisi-saldo-kas-' . $tahunText . '.pdf');
    }
}
