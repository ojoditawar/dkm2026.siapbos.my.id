<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pagu;
use App\Models\Level1;
use App\Models\Level2;
use App\Models\Tahun;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class PaguPrintController extends Controller
{
    public function print(Request $request)
    {
        // Ambil tahun aktif atau tahun yang dipilih
        $tahunId = $request->get('tahun_id');
        if (!$tahunId) {
            $tahunAktif = Tahun::where('aktif', true)->first();
            $tahunId = $tahunAktif ? $tahunAktif->id : null;
        }

        // Ambil data pagu dengan relasi lengkap, dikelompokkan berdasarkan level akun
        $pagus = Pagu::with([
            'level1',
            'level2',
            'sdana',
            'paguDetils',
            'tahun'
        ])
            ->when($tahunId, function ($query) use ($tahunId) {
                return $query->where('tahun_id', $tahunId);
            })
            ->orderBy('level1_id')
            ->orderBy('level2_id')
            ->get();

        // Debug: cek apakah data ada
        if ($pagus->isEmpty()) {
            // Jika tidak ada data dengan filter tahun, ambil semua data untuk testing
            $pagus = Pagu::with([
                'level1',
                'level2',
                'sdana',
                'paguDetils',
                'tahun'
            ])->get();
        }

        // Kelompokkan data berdasarkan level1 -> level2
        $groupedData = $pagus->groupBy(function ($pagu) {
            return $pagu->level1_id;
        })->map(function ($level1Group) {
            return $level1Group->groupBy(function ($pagu) {
                return $pagu->level2_id;
            });
        });

        // Hitung total keseluruhan
        $grandTotal = $pagus->sum('jumlah');

        $tahun = $tahunId ? Tahun::find($tahunId) : null;

        $pdf = FacadePdf::loadView('report.pagu', compact('groupedData', 'grandTotal', 'tahun'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan-Pagu-Anggaran-' . ($tahun ? $tahun->tahun : 'All') . '-' . now()->format('Ymd') . '.pdf');
    }
}
