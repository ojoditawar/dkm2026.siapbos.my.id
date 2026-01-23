<?php

namespace App\Http\Controllers;

use App\Models\Saldo;
use App\Models\Bukti;
use App\Models\Tahun;
use App\Models\Mutasi;
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
        $saldoData = Saldo::with(['level2', 'tahun'])
            ->when($tahunId, function ($query) use ($tahunId) {
                return $query->where('tahun_id', $tahunId);
            })
            ->whereNotNull('level2_id')
            ->orderBy('level2_id')
            ->get()
            ->groupBy('level2.nama');

        // Debug: Cek struktur data saldo
        // dd([
        //     'saldoData_count' => count($saldoData),
        //     'saldoData_keys' => array_keys($saldoData->toArray()),
        //     'saldoData_first_item' => $saldoData->first(),
        //     'saldoData_structure' => $saldoData->toArray()
        // ]);

        // Query data bukti dengan relasi dan filter tanggal
        $buktiData = Bukti::with([
            'pagudetil.pagu.level1',
            'pagudetil.pagu.level2',
            // 'anggaranDetailItem.anggaran.level3',
            // 'danaLevel3'
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

        // Query untuk mutasi kas dari tabel mutasis
        $mutasiQuery = Mutasi::with('detailMutasis.level2')
            ->when($tanggalMulai && $tanggalSampai, function ($query) use ($tanggalMulai, $tanggalSampai) {
                return $query->whereBetween('tanggal', [$tanggalMulai, $tanggalSampai]);
            })
            ->when(!$tanggalMulai && !$tanggalSampai && $tahunId && $tahun, function ($query) use ($tahun) {
                return $query->whereYear('tanggal', $tahun->tahun);
            })
            ->get();

        // Hitung perubahan saldo dari mutasi kas per level3
        $mutasiSaldoPerLevel3 = [];
        $mutasiDetailData = []; // Untuk debugging

        foreach ($mutasiQuery as $mutasi) {
            foreach ($mutasi->detailMutasis as $detail) {
                $level2Nama = $detail->level2->nama ?? 'Unknown';
                // Konversi jumlah ke numeric dengan benar
                $jumlahStr = str_replace([','], '', $detail->jumlah);
                $jumlah = (float) $jumlahStr;

                // Simpan detail untuk debugging
                $mutasiDetailData[] = [
                    'mutasi_nomor' => $mutasi->nomor,
                    'level2_nama' => $level2Nama,
                    'jumlah_original' => $detail->jumlah,
                    'jumlah_parsed' => $jumlah,
                    'kolom' => $detail->kolom
                ];

                // Jika kolom K, maka nilai menjadi minus
                if ($detail->kolom === 'K') {
                    $jumlah = -$jumlah;
                }

                if (!isset($mutasiSaldoPerLevel3[$level2Nama])) {
                    $mutasiSaldoPerLevel3[$level2Nama] = 0;
                }
                $mutasiSaldoPerLevel3[$level2Nama] += $jumlah;
            }
        }

        // Hitung total pemasukan (3 digit pertama nomor = 'PEN') - konversi ke float
        $totalPemasukan = (float) (clone $baseQuery)->where('nomor', 'LIKE', 'PEN%')->sum('jumlah');

        // Hitung total pengeluaran (3 digit pertama nomor = 'BEL') - konversi ke float
        $totalPengeluaran = (float) (clone $baseQuery)->where('nomor', 'LIKE', 'BEL%')->sum('jumlah');

        // Hitung total saldo per jenis kas - konversi ke float
        $totalSaldoPerJenis = [];
        foreach ($saldoData as $jenisKas => $saldos) {
            $total = 0;
            foreach ($saldos as $saldo) {
                // Bersihkan format "Rp25.000.000" menjadi angka
                $jumlahStr = str_replace(['Rp', '.', ','], '', $saldo->jumlah);
                $total += (float) $jumlahStr;
            }
            $totalSaldoPerJenis[$jenisKas] = $total;
        }

        // Hitung penerimaan dan pengeluaran per jenis kas dari bukti
        $penerimaanPerJenis = [];
        $pengeluaranPerJenis = [];

        foreach ($buktiData as $bukti) {
            $jenisKas = null;

            // Prioritas 1: Gunakan relasi danaLevel3 (field dana di tabel bukti)
            if ($bukti->danaLevel3) {
                $jenisKas = $bukti->danaLevel3->nama;
            }
            // Prioritas 2: Fallback ke anggaranDetailItem jika dana kosong
            elseif ($bukti->pagudetil && $bukti->pagudetil->pagu && $bukti->pagudetil->pagu->level2) {
                $jenisKas = $bukti->pagudetil->pagu->level2->nama;
            }

            if ($jenisKas) {
                $buktiJumlah = (float) $bukti->jumlah;
                if (substr($bukti->nomor, 0, 3) == 'PEN') {
                    $penerimaanPerJenis[$jenisKas] = ($penerimaanPerJenis[$jenisKas] ?? 0) + $buktiJumlah;
                } elseif (substr($bukti->nomor, 0, 3) == 'BEL') {
                    $pengeluaranPerJenis[$jenisKas] = ($pengeluaranPerJenis[$jenisKas] ?? 0) + $buktiJumlah;
                }
            }
        }

        // Gabungkan semua jenis kas (dari saldo, mutasi, penerimaan, pengeluaran)
        $allJenisKas = array_unique(array_merge(
            array_keys($totalSaldoPerJenis),
            array_keys($mutasiSaldoPerLevel3),
            array_keys($penerimaanPerJenis),
            array_keys($pengeluaranPerJenis)
        ));

        // Gabungkan saldo awal dengan semua perubahan - pastikan semua numeric
        $saldoAkhirPerJenis = [];
        foreach ($allJenisKas as $jenisKas) {
            $saldoAwal = (float) ($totalSaldoPerJenis[$jenisKas] ?? 0);
            $perubahanMutasi = (float) ($mutasiSaldoPerLevel3[$jenisKas] ?? 0);
            $penerimaan = (float) ($penerimaanPerJenis[$jenisKas] ?? 0);
            $pengeluaran = (float) ($pengeluaranPerJenis[$jenisKas] ?? 0);

            $saldoAkhirPerJenis[$jenisKas] = [
                'saldo_awal' => $saldoAwal,
                'perubahan_mutasi' => $perubahanMutasi,
                'penerimaan' => $penerimaan,
                'pengeluaran' => $pengeluaran,
                'saldo_akhir' => $saldoAwal + $perubahanMutasi + $penerimaan - $pengeluaran
            ];
        }

        // Hitung grand total saldo - pastikan semua numeric
        $grandTotalSaldo = (float) array_sum($totalSaldoPerJenis);
        $totalPerubahanMutasi = (float) array_sum($mutasiSaldoPerLevel3);
        $totalPenerimaanPerJenis = (float) array_sum($penerimaanPerJenis);
        $totalPengeluaranPerJenis = (float) array_sum($pengeluaranPerJenis);
        $grandTotalSaldoAkhir = $grandTotalSaldo + $totalPerubahanMutasi + $totalPenerimaanPerJenis - $totalPengeluaranPerJenis;

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
            'mutasi_data' => $mutasiQuery,
            'mutasi_detail_data' => $mutasiDetailData, // Debug data
            'mutasi_saldo_per_level3' => $mutasiSaldoPerLevel3,
            'saldo_akhir_per_jenis' => $saldoAkhirPerJenis,
            'total_saldo_per_jenis' => $totalSaldoPerJenis,
            'penerimaan_per_jenis' => $penerimaanPerJenis,
            'pengeluaran_per_jenis' => $pengeluaranPerJenis,
            'grand_total_saldo' => $grandTotalSaldo,
            'total_perubahan_mutasi' => $totalPerubahanMutasi,
            'total_penerimaan_per_jenis' => $totalPenerimaanPerJenis,
            'total_pengeluaran_per_jenis' => $totalPengeluaranPerJenis,
            'grand_total_saldo_akhir' => $grandTotalSaldoAkhir,
            'total_pemasukan' => $totalPemasukan,
            'total_pengeluaran' => $totalPengeluaran,
            'saldo_akhir' => $grandTotalSaldoAkhir + $totalPemasukan - $totalPengeluaran
        ];

        // Generate PDF
        $pdf = Pdf::loadView('report.saldo-kas-new', $data)
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
