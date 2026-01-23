<?php

namespace App\Filament\Widgets;

use App\Models\DetilAsnaf;
use App\Models\Asnaf;
use Filament\Widgets\ChartWidget;

class AsnafChartWidget extends ChartWidget
{
    protected ?string $heading = '📊 Grafik Santunan per Kelompok Asnaf';

    protected ?string $description = 'Total nilai santunan yang diberikan untuk setiap kelompok asnaf';

    protected int | string | array $columnSpan = 1;

    protected static ?int $sort = 4;

    protected function getData(): array
    {
        // Ambil 8 kelompok asnaf dengan total santunan terbesar
        // $asnafData = DetilAsnaf::join('asnafs', 'detil_asnafs.asnaf_id', '=', 'asnafs.id')
        //     ->selectRaw('asnafs.nama as nama_asnaf, SUM(detil_asnafs.satuan) as total_santunan')
        //     ->groupBy('asnafs.id', 'asnafs.nama')
        //     ->orderBy('total_santunan', 'desc')
        //     ->limit(8)
        //     ->get();

        // $labels = [];
        // $data = [];
        // $colors = [
        //     'rgba(16, 185, 129, 0.8)', // Green
        //     'rgba(59, 130, 246, 0.8)', // Blue
        //     'rgba(245, 158, 11, 0.8)', // Yellow
        //     'rgba(239, 68, 68, 0.8)', // Red
        //     'rgba(139, 92, 246, 0.8)', // Purple
        //     'rgba(6, 182, 212, 0.8)', // Cyan
        //     'rgba(249, 115, 22, 0.8)', // Orange
        //     'rgba(132, 204, 22, 0.8)', // Lime
        // ];

        // foreach ($asnafData as $index => $item) {
        //     $labels[] = $item->nama_asnaf;
        //     $data[] = (float) $item->total_santunan;
        // }

        // // Fallback data jika tidak ada data dari database
        // if (empty($data)) {
        //     $labels = ['Fakir', 'Miskin', 'Yatim', 'Piatu', 'Janda', 'Dhuafa', 'Muallaf', 'Gharim'];
        //     $data = [500000, 750000, 300000, 400000, 600000, 450000, 350000, 550000];
        // }

        // return [
        //     'datasets' => [
        //         [
        //             'label' => 'Total Santunan (Rp)',
        //             'data' => $data,
        //             'backgroundColor' => array_slice($colors, 0, count($data)),
        //             'borderColor' => array_map(function($color) {
        //                 return str_replace('0.8', '1', $color);
        //             }, array_slice($colors, 0, count($data))),
        //             'borderWidth' => 1,
        //         ],
        //     ],
        //     'labels' => $labels,
        // ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
                'datalabels' => [
                    'display' => true,
                    'anchor' => 'end',
                    'align' => 'top',
                    'formatter' => 'function(value) {
                        return new Intl.NumberFormat("id-ID", {
                            style: "currency",
                            currency: "IDR",
                            notation: "compact",
                            compactDisplay: "short"
                        }).format(value);
                    }',
                    'font' => [
                        'size' => 10,
                        'weight' => 'bold'
                    ]
                ]
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'display' => true,
                        'font' => [
                            'size' => 10
                        ]
                    ],
                    'grid' => [
                        'display' => true
                    ]
                ],
                'x' => [
                    'ticks' => [
                        'maxRotation' => 45,
                        'minRotation' => 0,
                        'font' => [
                            'size' => 10
                        ]
                    ],
                    'grid' => [
                        'display' => false
                    ]
                ]
            ],
            'responsive' => true,
            'maintainAspectRatio' => false,
            'aspectRatio' => 1.5,
            'layout' => [
                'padding' => [
                    'top' => 20,
                    'bottom' => 10,
                    'left' => 10,
                    'right' => 10
                ]
            ]
        ];
    }
}
