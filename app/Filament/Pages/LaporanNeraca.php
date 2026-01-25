<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Actions\Action;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Schemas\Schema;
use App\Models\Rekening;
use App\Models\Buku;
use App\Models\Transaksi;
use App\Models\detailTransaksi;
use App\Models\Masjid;
use Filament\Notifications\Notification;
use Barryvdh\DomPDF\Facade\Pdf;
use Coolsam\Flatpickr\Forms\Components\Flatpickr;
use Filament\Forms\Components\Radio;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class LaporanNeraca extends Page implements HasForms
{
    use InteractsWithForms;
    use HasPageShield;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-chart-bar';
    protected string $view = 'filament.pages.laporan-neraca';
    protected static ?string $navigationLabel = 'Laporan Neraca X';
    protected static ?string $title = 'Laporan Neraca (Balance Sheet)';
    protected static string|\UnitEnum|null $navigationGroup = 'Laporan Keuangan';
    protected static ?int $navigationSort = 1;

    public $tanggal_mulai;
    public $tanggal_akhir;
    public $masjid_id;
    public $data_neraca = [];

    public function mount(): void
    {
        $this->tanggal_mulai = now()->startOfYear()->format('Y-m-d');
        $this->tanggal_akhir = now()->format('Y-m-d');
        $this->masjid_id = Masjid::first()?->id;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('masjid_id')
                    ->label('Masjid')
                    ->options(Masjid::pluck('nama', 'id'))
                    ->required()
                    ->reactive(),
                Flatpickr::make('tanggal_mulai')
                    ->label('Tanggal Mulai')
                    ->required()
                    ->reactive(),
                Flatpickr::make('tanggal_akhir')
                    ->label('Tanggal Akhir')
                    ->required()
                    ->reactive(),
                Radio::make('status')
                    ->inline()
                    ->options([
                        'realisasi' => 'Realisasi',
                        'rekening' => 'Rekening',
                    ])
                    ->descriptions([
                        'realisasi' => 'Neraca Berdasarkan Transaksi',
                        'rekening' => 'Format Neraca Berdasarkan Akun',
                    ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generateReport')
                ->label('Generate Laporan')
                ->icon('heroicon-o-document-chart-bar')
                ->color('primary')
                ->action('generateNeraca'),
            Action::make('exportPdf')
                ->label('Export PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->action('exportToPdf')
                ->visible(fn() => !empty($this->data_neraca)),
        ];
    }

    public function generateNeraca(): void
    {
        try {
            $this->data_neraca = $this->calculateNeraca();

            Notification::make()
                ->title('Laporan Berhasil Dibuat')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Gagal Membuat Laporan')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    private function calculateNeraca(): array
    {
        // Initialize hierarchical neraca structure
        $neraca = [
            'aset' => [],
            'kewajiban' => [],
            'ekuitas' => []
        ];

        // Get hierarchical structure: Rek -> SubRek -> Rekening
        $reks = \App\Models\Rek::with(['subRek.rekenings'])->orderBy('kode')->get();

        foreach ($reks as $rek) {
            $rekCode = substr($rek->kode ?? '', 0, 1);

            // Determine which section this Rek belongs to
            $section = null;
            switch ($rekCode) {
                case '1':
                    $section = 'aset';
                    break;
                case '2':
                    $section = 'kewajiban';
                    break;
                case '3':
                    $section = 'ekuitas';
                    break;
                default:
                    continue 2; // Skip if not 1, 2, or 3
            }

            // Create Rek level (Level 1)
            $rekItem = [
                'level' => 1,
                'kode' => $rek->kode,
                'nama' => $rek->nama,
                'saldo' => 0,
                'children' => []
            ];

            // Add SubRek level (Level 2)
            foreach ($rek->subRek->sortBy('kelompok') as $subRek) {
                $subRekItem = [
                    'level' => 2,
                    'kode' => $subRek->kelompok,
                    'nama' => $subRek->nama,
                    'saldo' => 0,
                    'children' => []
                ];

                // Add Rekening level (Level 3)
                foreach ($subRek->rekenings->sortBy('jenis') as $rekening) {
                    $rekeningItem = [
                        'level' => 3,
                        'kode' => $rekening->jenis ?? $rekening->akun, // Use jenis for full code like 1.01.01
                        'nama' => $rekening->nama,
                        'saldo' => 0,
                        'children' => []
                    ];

                    $subRekItem['children'][] = $rekeningItem;
                }

                // Only add subRek if it has rekening children
                if (!empty($subRekItem['children'])) {
                    $rekItem['children'][] = $subRekItem;
                }
            }

            // Only add rek if it has subRek children
            if (!empty($rekItem['children'])) {
                $neraca[$section][] = $rekItem;
            }
        }

        return $neraca;
    }

    public function exportToPdf()
    {
        // Generate data neraca
        $this->generateNeraca();

        if (empty($this->data_neraca)) {
            Notification::make()
                ->title('Error')
                ->body('Tidak ada data untuk diekspor. Silakan generate laporan terlebih dahulu.')
                ->danger()
                ->send();
            return;
        }

        // Store data in session for PDF generation
        session([
            'neraca_export_data' => [
                'data_neraca' => $this->data_neraca,
                'masjid_id' => $this->masjid_id,
                'tanggal_mulai' => $this->tanggal_mulai,
                'tanggal_akhir' => $this->tanggal_akhir,
            ]
        ]);

        // Redirect to PDF route
        $this->redirect(route('laporan.neraca.pdf'));
    }
}
