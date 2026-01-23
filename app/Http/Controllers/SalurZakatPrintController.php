<?php

namespace App\Http\Controllers;

use App\Models\SalurZakat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SalurZakatPrintController extends Controller
{
    public function print($id)
    {
        // Ambil data salur zakat dengan relasi details dan detil_asnaf
        $salurZakat = SalurZakat::with(['details.detilAsnaf'])->findOrFail($id);

        // Hitung total bantuan
        $totalBantuan = $salurZakat->details->sum('satuan');

        // Data untuk view
        $data = [
            'salur_zakat' => $salurZakat,
            'details' => $salurZakat->details,
            'total_bantuan' => $totalBantuan,
            'tanggal_cetak' => now()->format('d/m/Y H:i'),
        ];

        // Generate PDF
        $pdf = Pdf::loadView('report.salur-zakat-detail', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Laporan-Detail-Salur-Zakat-' . $salurZakat->nomor . '.pdf');
    }
}
