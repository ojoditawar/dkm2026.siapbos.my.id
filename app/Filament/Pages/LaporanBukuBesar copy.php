<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Actions\Action;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use App\Models\Rekening;
use App\Models\Buku;
use App\Models\Transaksi;
use App\Models\detailTransaksi;
use App\Models\Masjid;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification;
use Coolsam\Flatpickr\Forms\Components\Flatpickr;

class LaporanBukuBesar extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-book-open';
    protected string $view = 'filament.pages.laporan-buku-besar';
    protected static ?string $navigationLabel = 'Laporan Buku Besar';
    protected static ?string $title = 'Laporan Buku Besar (General Ledger)';
    protected static string|\UnitEnum|null $navigationGroup = 'Laporan Keuangan';
    protected static ?int $navigationSort = 2;

    public $tanggal_mulai;
    public $tanggal_akhir;
    public $masjid_id;
    public $rekening_id;
    public $data_buku_besar = [];

    public function mount(): void
    {
        $this->tanggal_mulai = now()->startOfMonth()->format('Y-m-d');
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
                Select::make('rekening_id')
                    ->label('Rekening')
                    ->options(Rekening::query()
                        ->selectRaw("id, CONCAT(akun, ' - ', nama) as display")
                        ->pluck('display', 'id'))
                    ->searchable()
                    ->placeholder('Pilih rekening atau kosongkan untuk semua rekening'),
                Flatpickr::make('tanggal_mulai')
                    ->required()
                    ->time(false)
                    ->date(true)
                    ->reactive(),
                Flatpickr::make('tanggal_akhir')
                    ->required()
                    ->time(false)
                    ->date(true)
                    ->reactive(),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generateReport')
                ->label('Generate Laporan')
                ->icon('heroicon-o-book-open')
                ->color('primary')
                ->action('generateBukuBesar'),
            Action::make('exportPdf')
                ->label('Export PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->action('exportToPdf')
                ->visible(fn() => !empty($this->data_buku_besar)),
        ];
    }

    public function generateBukuBesar(): void
    {
        try {
            $this->data_buku_besar = $this->calculateBukuBesar();

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

    private function calculateBukuBesar(): array
    {
        $query = Transaksi::with(['detailTransaksi', 'masjid'])
            ->whereBetween('tanggal', [$this->tanggal_mulai, $this->tanggal_akhir])
            ->orderBy('tanggal')
            ->orderBy('no_trans');

        if ($this->masjid_id) {
            $query->where('masjid_id', $this->masjid_id);
        }

        $transaksis = $query->get();

        // Get rekening list through mapping
        $rekeningQuery = Rekening::query();
        if ($this->rekening_id) {
            $rekeningQuery->where('id', $this->rekening_id);
        }
        $rekenings = $rekeningQuery->get();

        $bukuBesar = [];

        foreach ($rekenings as $rekening) {
            $entries = [];
            $saldoAwal = $this->getSaldoAwal($rekening->id);
            $runningSaldo = $saldoAwal;

            // Add opening balance entry
            if ($saldoAwal != 0) {
                $entries[] = [
                    'tanggal' => $this->tanggal_mulai,
                    'no_trans' => '',
                    'uraian' => 'Saldo Awal',
                    'debet' => $saldoAwal > 0 ? $saldoAwal : 0,
                    'kredit' => $saldoAwal < 0 ? abs($saldoAwal) : 0,
                    'saldo' => $runningSaldo
                ];
            }

            foreach ($transaksis as $transaksi) {
                // Check if this transaction affects this rekening through mapping
                if ($this->transactionAffectsRekening($transaksi, $rekening->id)) {
                    // Get the mapping to determine debit/credit position
                    $mapping = \App\Models\MappingRekening::where('mapping', $rekening->jenis)
                        ->where('transaksi', $transaksi->jenis)
                        ->where('bayar', $transaksi->bayar)
                        ->first();

                    if ($mapping) {
                        foreach ($transaksi->detailTransaksi as $detail) {
                            $debet = 0;
                            $kredit = 0;

                            // Use mapping's kolom field to determine debit/credit
                            // Assuming kolom field indicates: 'D' for debit, 'K' for credit
                            if ($mapping->kolom === 'D' || $mapping->kolom === 'debet') {
                                $debet = $detail->jumlah;
                                $runningSaldo += $detail->jumlah;
                            } else {
                                $kredit = $detail->jumlah;
                                $runningSaldo -= $detail->jumlah;
                            }

                            $entries[] = [
                                'tanggal' => $transaksi->tanggal->format('Y-m-d'),
                                'no_trans' => $transaksi->no_trans,
                                'uraian' => $detail->uraian,
                                'debet' => $debet,
                                'kredit' => $kredit,
                                'saldo' => $runningSaldo
                            ];
                        }
                    }
                }
            }

            // Only include accounts with transactions
            if (!empty($entries)) {
                $bukuBesar[] = [
                    'rekening' => $rekening,
                    'entries' => $entries,
                    'total_debet' => collect($entries)->sum('debet'),
                    'total_kredit' => collect($entries)->sum('kredit'),
                    'saldo_akhir' => $runningSaldo
                ];
            }
        }

        return $bukuBesar;
    }

    private function getSaldoAwal($rekeningId): float
    {
        // Calculate opening balance before the start date
        $transaksis = Transaksi::with(['detailTransaksi'])
            ->where('tanggal', '<', $this->tanggal_mulai)
            ->get();

        $saldo = 0;
        foreach ($transaksis as $transaksi) {
            if ($this->transactionAffectsRekening($transaksi, $rekeningId)) {
                foreach ($transaksi->detailTransaksi as $detail) {
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

    private function transactionAffectsRekening($transaksi, $rekeningId): bool
    {
        // Get the rekening object to get its jenis
        $rekening = Rekening::find($rekeningId);
        if (!$rekening) {
            return false;
        }

        // Check if transaction's rekening field matches through MappingRekening
        // The rekening field in transaksi contains jenis value that should be mapped
        $mappingExists = \App\Models\MappingRekening::where('mapping', $rekening->jenis)
            ->where('transaksi', $transaksi->jenis) // Match transaction type
            ->where('bayar', $transaksi->bayar) // Match payment method
            ->exists();

        return $mappingExists;
    }

    private function isDebitAccount($rekening): bool
    {
        // Determine if account is normally debit (Assets, Expenses) or credit (Liabilities, Equity, Revenue)
        $jenisCode = substr($rekening->jenis ?? '', 0, 1);
        return in_array($jenisCode, ['1', '5']); // Assets and Expenses are debit accounts
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
