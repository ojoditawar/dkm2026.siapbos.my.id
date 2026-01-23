<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Level1;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use PDF;

class Level1PrintController extends Controller
{
    public function show(Level1 $level1)
    {
        // Kalau mau HTML siap-print:
        // return view('report.level1', [
        //     'record' => $level1,
        // ]);

        // $level1s = Level1::orderBy('akun1')->get();
        $level1s = Level1::orderBy('akun1')->paginate(10);

        $pdf = FacadePdf::loadView('report.level1', compact('level1s'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan-Level1-' . now()->format('Ymd') . '.pdf');
    }
}
