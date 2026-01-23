<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggaran;
use App\Models\Level1;
use App\Models\Level2;
use App\Models\Level3;
use App\Models\Tahun;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class AnggaranPrintController extends Controller
{
    public function print(Request $request)
    {
        // Ambil tahun aktif atau tahun yang dipilih
        $tahunId = $request->get('tahun_id');
        if (!$tahunId) {
            $tahunAktif = Tahun::where('aktif', true)->first();
            $tahunId = $tahunAktif ? $tahunAktif->id : null;
        }

        // Ambil data anggaran dengan relasi lengkap, dikelompokkan berdasarkan level akun
        $anggarans = Anggaran::with([
            'level1',
            'level2',
            'level3',
            'sumber_dana',
            'sub_dana',
            'detailItems',
            'tahun'
        ])
            ->when($tahunId, function ($query) use ($tahunId) {
                return $query->where('tahun_id', $tahunId);
            })
            ->orderBy('level1_id')
            ->orderBy('level2_id')
            ->orderBy('level3_id')
            ->get();

        // Kelompokkan data berdasarkan level1 -> level2 -> level3
        $groupedData = $anggarans->groupBy(function ($anggaran) {
            return $anggaran->level1_id;
        })->map(function ($level1Group) {
            return $level1Group->groupBy(function ($anggaran) {
                return $anggaran->level2_id;
            })->map(function ($level2Group) {
                return $level2Group->groupBy(function ($anggaran) {
                    return $anggaran->level3_id;
                });
            });
        });

        // Hitung total keseluruhan
        $grandTotal = $anggarans->sum(function ($anggaran) {
            return $anggaran->getCalculatedGrandTotal();
        });

        $tahun = $tahunId ? Tahun::find($tahunId) : null;

        $pdf = FacadePdf::loadView('report.anggaran', compact('groupedData', 'grandTotal', 'tahun'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan-Anggaran-' . ($tahun ? $tahun->tahun : 'All') . '-' . now()->format('Ymd') . '.pdf');
    }
}
