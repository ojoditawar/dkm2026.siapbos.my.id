<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Masjid;

class LaporanBukuBesarPdfController extends Controller
{
    public function generate()
    {
        // Retrieve data from session
        $bukuBesar = session('buku_besar_data');
        $params = session('buku_besar_params');

        if (!$bukuBesar || !$params) {
            return redirect()->back()->with('error', 'Data laporan tidak ditemukan');
        }

        // Get masjid info
        $masjid = null;
        if ($params['masjid_id']) {
            $masjid = Masjid::find($params['masjid_id']);
        }

        // Prepare data for PDF
        $data = [
            'bukuBesar' => $bukuBesar,
            'tanggal_mulai' => $params['tanggal_mulai'],
            'tanggal_akhir' => $params['tanggal_akhir'],
            'masjid' => $masjid,
            'rekening_id' => $params['rekening_id']
        ];

        // Clear session data
        session()->forget(['buku_besar_data', 'buku_besar_params']);

        // Generate PDF
        $pdf = Pdf::loadView('report.buku-besar', $data);
        $pdf->setPaper('A4', 'portrait');

        // Download PDF
        $filename = 'laporan-buku-besar-' . date('Y-m-d-H-i-s') . '.pdf';
        return $pdf->download($filename);
    }
}
