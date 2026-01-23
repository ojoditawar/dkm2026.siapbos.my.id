<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Actions\Action;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Schemas\Schema;
// use Filament\Support\Icons\Heroicon;
use App\Models\Rekening;
use App\Models\Buku;
use App\Models\Transaksi;
use App\Models\detailTransaksi;
use App\Models\Masjid;
// use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification;

class LaporanNeraca extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-chart-bar';
    protected string $view = 'filament.pages.laporan-neraca';
    protected static ?string $navigationLabel = 'Laporan Neraca';
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
                DatePicker::make('tanggal_mulai')
                    ->label('Tanggal Mulai')
                    ->required()
                    ->reactive(),
                DatePicker::make('tanggal_akhir')
                    ->label('Tanggal Akhir')
                    ->required()
                    ->reactive(),
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
        $query = Transaksi::with(['detailTransaksi'])
            ->whereBetween('tanggal', [$this->tanggal_mulai, $this->tanggal_akhir]);

        if ($this->masjid_id) {
            $query->where('masjid_id', $this->masjid_id);
        }

        $transaksis = $query->get();

        // Initialize neraca structure
        $neraca = [
            'aktiva' => [
                'aktiva_lancar' => [],
                'aktiva_tetap' => [],
                'total_aktiva' => 0
            ],
            'pasiva' => [
                'kewajiban' => [],
                'ekuitas' => [],
                'total_pasiva' => 0
            ]
        ];

        // Get all rekening for classification
        $rekenings = Rekening::with(['rek', 'subRek'])->get();

        foreach ($rekenings as $rekening) {
            $saldo = $this->calculateSaldoRekening($rekening->id, $transaksis);

            if ($saldo != 0) {
                $item = [
                    'kode' => $rekening->akun,
                    'nama' => $rekening->nama,
                    'saldo' => $saldo
                ];

                // Classify based on account type (simplified logic)
                $jenisCode = substr($rekening->jenis ?? '', 0, 1);

                switch ($jenisCode) {
                    case '1': // Aktiva
                        if (in_array(substr($rekening->jenis ?? '', 0, 2), ['11', '12', '13'])) {
                            $neraca['aktiva']['aktiva_lancar'][] = $item;
                        } else {
                            $neraca['aktiva']['aktiva_tetap'][] = $item;
                        }
                        $neraca['aktiva']['total_aktiva'] += $saldo;
                        break;
                    case '2': // Kewajiban
                        $neraca['pasiva']['kewajiban'][] = $item;
                        $neraca['pasiva']['total_pasiva'] += $saldo;
                        break;
                    case '3': // Ekuitas
                        $neraca['pasiva']['ekuitas'][] = $item;
                        $neraca['pasiva']['total_pasiva'] += $saldo;
                        break;
                }
            }
        }

        return $neraca;
    }

    private function calculateSaldoRekening($rekeningId, $transaksis): float
    {
        $saldo = 0;

        foreach ($transaksis as $transaksi) {
            // Check if this transaction affects this rekening
            if (
                $transaksi->rekening == $rekeningId ||
                str_contains($transaksi->kode ?? '', (string)$rekeningId)
            ) {

                foreach ($transaksi->detailTransaksi as $detail) {
                    // Add logic based on transaction type (debit/credit)
                    if ($transaksi->jenis == 'masuk') {
                        $saldo += $detail->jumlah;
                    } else {
                        $saldo -= $detail->jumlah;
                    }
                }
            }
        }

        return $saldo;
    }

    public function exportToPdf(): void
    {
        // Implementation for PDF export would go here
        Notification::make()
            ->title('Export PDF')
            ->body('Fitur export PDF akan segera tersedia')
            ->info()
            ->send();
    }
}
