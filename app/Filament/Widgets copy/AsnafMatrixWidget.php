<?php

namespace App\Filament\Widgets;

use App\Models\DetilAsnaf;
use App\Models\Asnaf;
use Filament\Widgets\Widget;
use Illuminate\Support\Collection;

class AsnafMatrixWidget extends Widget
{
    protected string $view = 'filament.widgets.asnaf-matrix-widget';
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = 2;
    
    protected function getViewData(): array
    {
        // Ambil semua jenis asnaf
        $jenisAsnaf = ['UMUM', 'SD', 'SMP', 'SMA', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'];
        
        // Ambil semua kelompok asnaf
        $kelompokAsnaf = Asnaf::orderBy('nama')->get();
        
        // Ambil data detail asnaf dengan grouping
        $detailData = DetilAsnaf::with('asnaf')
            ->selectRaw('asnaf_id, jenis, COUNT(*) as jumlah_penerima, SUM(CAST(satuan AS DECIMAL(15,2))) as total_alokasi')
            ->groupBy('asnaf_id', 'jenis')
            ->get()
            ->groupBy('asnaf_id');
        
        // Buat matrix data
        $matrixData = [];
        foreach ($kelompokAsnaf as $kelompok) {
            $matrixData[$kelompok->id] = [
                'nama' => $kelompok->nama,
                'data' => []
            ];
            
            foreach ($jenisAsnaf as $jenis) {
                $data = $detailData->get($kelompok->id, collect())->firstWhere('jenis', $jenis);
                $matrixData[$kelompok->id]['data'][$jenis] = [
                    'jumlah_penerima' => $data ? $data->jumlah_penerima : 0,
                    'total_alokasi' => $data ? $data->total_alokasi : 0
                ];
            }
        }
        
        // Hitung total per jenis
        $totalPerJenis = [];
        foreach ($jenisAsnaf as $jenis) {
            $totalPenerima = 0;
            $totalAlokasi = 0;
            
            foreach ($matrixData as $kelompokData) {
                $totalPenerima += $kelompokData['data'][$jenis]['jumlah_penerima'];
                $totalAlokasi += $kelompokData['data'][$jenis]['total_alokasi'];
            }
            
            $totalPerJenis[$jenis] = [
                'jumlah_penerima' => $totalPenerima,
                'total_alokasi' => $totalAlokasi
            ];
        }
        
        // Hitung total per kelompok
        $totalPerKelompok = [];
        foreach ($matrixData as $kelompokId => $kelompokData) {
            $totalPenerima = 0;
            $totalAlokasi = 0;
            
            foreach ($kelompokData['data'] as $jenisData) {
                $totalPenerima += $jenisData['jumlah_penerima'];
                $totalAlokasi += $jenisData['total_alokasi'];
            }
            
            $totalPerKelompok[$kelompokId] = [
                'jumlah_penerima' => $totalPenerima,
                'total_alokasi' => $totalAlokasi
            ];
        }
        
        // Grand total
        $grandTotal = [
            'jumlah_penerima' => array_sum(array_column($totalPerJenis, 'jumlah_penerima')),
            'total_alokasi' => array_sum(array_column($totalPerJenis, 'total_alokasi'))
        ];
        
        return [
            'jenisAsnaf' => $jenisAsnaf,
            'matrixData' => $matrixData,
            'totalPerJenis' => $totalPerJenis,
            'totalPerKelompok' => $totalPerKelompok,
            'grandTotal' => $grandTotal
        ];
    }
}
