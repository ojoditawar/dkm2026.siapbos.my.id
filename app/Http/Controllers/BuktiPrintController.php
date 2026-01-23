<?php

namespace App\Http\Controllers;

use App\Models\Bukti;
use Barryvdh\DomPDF\Facade\Pdf;

class BuktiPrintController extends Controller
{

    public function show(Bukti $bukti)
    {
        // Load relasi
        $bukti->load([
            'pagudetil.pagu.level1',
            'pagudetil.pagu.level2',
            // 'pagudetil.pagu.level3'
        ]);

        // Menggunakan Laravel DomPDF facade dengan ukuran A5 landscape
        $pdf = Pdf::loadView('report.bukti', compact('bukti'))
            ->setPaper('A5', 'landscape') // A5 landscape untuk QR Code
            //  ->setPaper([0, 0, 419.53, 297.64], 'landscape') // A6 landscape dalam points
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'DejaVu Sans',
                'isFontSubsettingEnabled' => true,
                'chroot' => public_path(),
            ]);

        return $pdf->stream('kuitansi-' . ($bukti->nomor ?? $bukti->kode) . '.pdf');
    }
}
