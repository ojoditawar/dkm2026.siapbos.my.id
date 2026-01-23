<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pagu;
// use App\Models\Rek;
// use App\Models\SubRek;
// use App\Models\Rekening;
use App\Models\Tahun;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class PaguPrintController extends Controller
{
    public function print(Request $request)
    {
        // Ambil tahun aktif atau tahun yang dipilih
        $tahun = $request->get('tahun');
        if (!$tahun) {
            $tahunAktif = Tahun::where('aktif', true)->first();
            $tahun = $tahunAktif ? $tahunAktif->tahun : date('Y');
        }

        // Ambil data pagu dengan relasi lengkap, dikelompokkan berdasarkan akun
        $pagus = Pagu::with([
            'rek',
            'subRek',
            'reken',
            'paguDetils'
        ])
            ->when($tahun, function ($query) use ($tahun) {
                return $query->where('tahun', $tahun);
            })
            ->orderBy('rek_id')
            ->orderBy('sub_rek_id')
            ->orderBy('rekening_id')
            ->get();

        // Debug: cek apakah data ada
        if ($pagus->isEmpty()) {
            // Jika tidak ada data dengan filter tahun, ambil semua data untuk testing
            $pagus = Pagu::with([
                'rek',
                'subRek',
                'reken',
                'paguDetils'
            ])->get();
        }

        // Ambil tahun dari data pagu pertama jika ada
        $tahunValue = $pagus->isNotEmpty() ? $pagus->first()->tahun : $tahun;

        // Kelompokkan data berdasarkan rek -> subRek -> rekening
        $groupedData = $pagus->groupBy(function ($pagu) {
            return $pagu->rek_id;
        })->map(function ($rekGroup) {
            return $rekGroup->groupBy(function ($pagu) {
                return $pagu->sub_rek_id;
            })->map(function ($subRekGroup) {
                return $subRekGroup->groupBy(function ($pagu) {
                    return $pagu->rekening_id;
                });
            });
        });

        // Hitung total dari pagu details
        $totalAnggaran = $pagus->sum(function ($pagu) {
            return $pagu->paguDetils->sum('total');
        });

        // Hitung berdasarkan kode akun: '4' adalah Pendapatan, '5' adalah Belanja
        $totalPendapatan = $pagus->where('rek_id', '4')->sum(function ($pagu) {
            return $pagu->paguDetils->sum('total');
        });
        $totalBelanja = $pagus->where('rek_id', '5')->sum(function ($pagu) {
            return $pagu->paguDetils->sum('total');
        });
        $grandTotal = $totalPendapatan - $totalBelanja;

        $tahunObj = $tahun ? Tahun::where('tahun', $tahun)->first() : null;

        // Debug: cek data yang dikirim ke view
        // dd([
        //     'pagus_count' => $pagus->count(),
        //     'grand_total' => $grandTotal,
        //     'grouped_data' => $groupedData,
        //     'sample_pagu' => $pagus->first(),
        //     'tahun' => $tahun
        // ]);

        $pdf = FacadePdf::loadView('report.pagu', compact('groupedData', 'grandTotal', 'tahunValue', 'pagus', 'totalPendapatan', 'totalBelanja', 'totalAnggaran'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan-Pagu-Anggaran-' . $tahunValue . '-' . now()->format('Ymd') . '.pdf');
    }
}
