<?php

namespace App\Filament\Widgets;

use App\Models\DetilAsnaf;
use App\Models\Asnaf;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AsnafSummaryWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 3;

    protected function getStats(): array
    {
        // Total penerima dan alokasi
        $totalPenerima = DetilAsnaf::count();
        $totalAlokasi = DetilAsnaf::sum('satuan');

        // Data per jenis
        $dataUmum = DetilAsnaf::where('jenis', 'UMUM')->selectRaw('COUNT(*) as jumlah, SUM(satuan) as total')->first();
        $dataBeasiswa = DetilAsnaf::where('jenis', '!=', 'UMUM')->selectRaw('COUNT(*) as jumlah, SUM(satuan) as total')->first();

        // Kelompok asnaf terbanyak
        $kelompokTerbanyak = DetilAsnaf::with('asnaf')
            ->selectRaw('asnaf_id, COUNT(*) as jumlah')
            ->groupBy('asnaf_id')
            ->orderBy('jumlah', 'desc')
            ->first();

        return [
            Stat::make('Total Penerima Asnaf', number_format($totalPenerima))
                ->description('Seluruh penerima zakat')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),

            Stat::make('Total Alokasi Dana', 'Rp ' . number_format($totalAlokasi, 0, ',', '.'))
                ->description('Total dana yang dialokasikan')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary'),

            Stat::make('Penerima Umum', number_format($dataUmum->jumlah ?? 0))
                ->description('Rp ' . number_format($dataUmum->total ?? 0, 0, ',', '.'))
                ->descriptionIcon('heroicon-m-user-group')
                ->color('warning'),

            Stat::make('Penerima Beasiswa', number_format($dataBeasiswa->jumlah ?? 0))
                ->description('Rp ' . number_format($dataBeasiswa->total ?? 0, 0, ',', '.'))
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('info'),

            Stat::make('Kelompok Terbanyak', $kelompokTerbanyak->asnaf->nama ?? 'Belum ada data')
                ->description(number_format($kelompokTerbanyak->jumlah ?? 0) . ' penerima')
                ->descriptionIcon('heroicon-m-trophy')
                ->color('success'),
        ];
    }
}
