<?php

namespace App\Http\Controllers;

use App\Models\Masjid;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanNeracaPdfController extends Controller
{
    public function export()
    {
        // Get data from session
        $exportData = session('neraca_export_data');

        if (!$exportData) {
            abort(404, 'Data export tidak ditemukan. Silakan generate laporan terlebih dahulu.');
        }

        // Get masjid data
        $masjid = $exportData['masjid_id'] ? Masjid::find($exportData['masjid_id']) : null;

        // Generate PDF
        $pdf = Pdf::loadView('report.neraca', [
            'data_neraca' => $exportData['data_neraca'],
            'masjid' => $masjid,
            'tanggal_mulai' => $exportData['tanggal_mulai'],
            'tanggal_akhir' => $exportData['tanggal_akhir'],
        ])
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'DejaVu Sans',
                'isFontSubsettingEnabled' => true,
                'chroot' => public_path(),
            ]);

        // Generate filename
        $filename = 'laporan-neraca-' .
            ($masjid ? str_replace(' ', '-', strtolower($masjid->nama)) . '-' : '') .
            \Carbon\Carbon::parse($exportData['tanggal_mulai'])->format('Y-m-d') . '-to-' .
            \Carbon\Carbon::parse($exportData['tanggal_akhir'])->format('Y-m-d') . '.pdf';

        // Clear session data
        session()->forget('neraca_export_data');

        // Download PDF directly
        return $pdf->download($filename);
    }
}
