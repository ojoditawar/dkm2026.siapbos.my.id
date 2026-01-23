<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Level1;
use App\Models\Level2;
use App\Models\Level3;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class Level2PrintController extends Controller
{
    public function show()
    {
        // Ambil data Level1 dengan relasi Level2 dan Level3 secara hierarkis
        $level1s = Level1::with(['level2s.level3s'])
            ->orderBy('akun1')
            ->get();

        $pdf = FacadePdf::loadView('report.level2', compact('level1s'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan-Struktur-Akun-' . now()->format('Ymd') . '.pdf');
    }
}
