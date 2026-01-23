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
                        // ->selectRaw("id, CONCAT(akun, ' - ', nama) as display")
                        // ->pluck('display', 'id'))
                        ->selectRaw("id, nama")
                        ->pluck('nama', 'id'))
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
        // Query sederhana menggunakan DB facade untuk join dengan mapping_rekening
        // $query = DB::table('detail_transaksis')
        //     ->join('transaksis', 'detail_transaksis.transaksi_id', '=', 'transaksis.id')
        //     ->join('mapping_rekenings', function ($join) {
        //         $join->on('transaksis.rekening', '=', 'mapping_rekenings.mapping')
        //             ->on('transaksis.bayar', '=', 'mapping_rekenings.bayar')
        //             ->on('transaksis.jenis', '=', 'mapping_rekenings.transaksi');
        //     })
        //     ->select(
        //         'transaksis.no_trans',
        //         'transaksis.tanggal',
        //         'detail_transaksis.uraian',
        //         'detail_transaksis.jumlah',
        //         'mapping_rekenings.jurnal',
        //         'mapping_rekenings.kolom',
        //         'transaksis.jenis',
        //         'transaksis.bayar'
        //     )
        //     ->whereBetween('transaksis.tanggal', [$this->tanggal_mulai, $this->tanggal_akhir])
        //     ->orderBy('transaksis.tanggal')
        //     ->orderBy('transaksis.no_trans');

        $query = DB::table('detail_transaksis')
            ->join('transaksis', 'detail_transaksis.transaksi_id', '=', 'transaksis.id')
            // --- TAMBAHKAN JOIN KE TABEL MASJID DISINI ---
            ->join('masjids', 'transaksis.masjid_id', '=', 'masjids.id')
            ->leftJoin('mapping_rekenings', function ($join) {
                $join->on(DB::raw('TRIM(transaksis.rekening)'), '=', DB::raw('TRIM(mapping_rekenings.mapping)'))
                    ->on(DB::raw('TRIM(transaksis.bayar)'), '=', DB::raw('TRIM(mapping_rekenings.bayar)'))
                    ->on(DB::raw('TRIM(transaksis.jenis)'), '=', DB::raw('TRIM(mapping_rekenings.transaksi)'));
            })
            ->whereBetween('transaksis.tanggal', [$this->tanggal_mulai, $this->tanggal_akhir])
            ->where('transaksis.masjid_id', $this->masjid_id)
            ->select(
                'transaksis.no_trans',
                'transaksis.tanggal',
                'masjids.nama as nama_masjid', // --- TAMBAHKAN KOLOM NAMA MASJID ---
                'detail_transaksis.uraian',
                'detail_transaksis.jumlah',
                'mapping_rekenings.jurnal',
                'mapping_rekenings.kolom',
                'transaksis.jenis',
                'transaksis.bayar'
            )
            ->whereBetween('transaksis.tanggal', [$this->tanggal_mulai, $this->tanggal_akhir]);

        // dd($query->get()); //ada

        // if ($this->masjid_id) {
        //     $query->where('transaksis.masjid_id', $this->masjid_id);
        // }

        $transaksiData = $query->get();

        // dd($transaksiData);

        // Get rekening list
        $rekeningQuery = Rekening::query();
        if ($this->rekening_id) {
            $rekeningQuery->where('id', $this->rekening_id);
        }
        // dd($rekeningQuery->get());

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

            // Filter transaksi data untuk rekening ini
            $rekeningTransaksi = $transaksiData->filter(function ($item) use ($rekening) {
                return $item->jurnal === $rekening->jenis;
            });

            foreach ($rekeningTransaksi as $item) {
                $debet = 0;
                $kredit = 0;

                // Gunakan kolom dari mapping untuk menentukan debet/kredit
                if ($item->kolom === 'D' || strtolower($item->kolom) === 'debet') {
                    $debet = $item->jumlah;
                    $runningSaldo += $item->jumlah;
                } else {
                    $kredit = $item->jumlah;
                    $runningSaldo -= $item->jumlah;
                }

                $entries[] = [
                    'tanggal' => $item->tanggal,
                    'no_trans' => $item->no_trans,
                    'uraian' => $item->uraian,
                    'debet' => $debet,
                    'kredit' => $kredit,
                    'saldo' => $runningSaldo
                ];
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
        // Get rekening to get its jenis
        $rekening = Rekening::find($rekeningId);
        if (!$rekening) {
            return 0;
        }

        // Calculate opening balance before the start date using query builder
        $saldoData = DB::table('detail_transaksis')
            ->join('transaksis', 'detail_transaksis.transaksi_id', '=', 'transaksis.id')
            ->leftJoin('mapping_rekenings', function ($join) {
                $join->on(DB::raw('TRIM(transaksis.rekening)'), '=', DB::raw('TRIM(mapping_rekenings.mapping)'))
                    ->on(DB::raw('TRIM(transaksis.bayar)'), '=', DB::raw('TRIM(mapping_rekenings.bayar)'))
                    ->on(DB::raw('TRIM(transaksis.jenis)'), '=', DB::raw('TRIM(mapping_rekenings.transaksi)'));
            })
            ->where('mapping_rekenings.jurnal', $rekening->jenis)
            ->where('transaksis.tanggal', '<', $this->tanggal_mulai)
            ->select('detail_transaksis.jumlah', 'mapping_rekenings.kolom')
            ->get();

        $saldo = 0;
        foreach ($saldoData as $item) {
            if ($item->kolom === 'D' || strtolower($item->kolom) === 'debet') {
                $saldo += $item->jumlah;
            } else {
                $saldo -= $item->jumlah;
            }
        }

        return $saldo;
    }

    private function transactionAffectsRekening($transaksi, $rekeningId): bool
    {
        return $transaksi->rekening == $rekeningId ||
            str_contains($transaksi->kode ?? '', (string)$rekeningId);
    }

    private function isDebitAccount($rekening): bool
    {
        // Determine if account is normally debit (Assets, Expenses) or credit (Liabilities, Equity, Revenue)
        $jenisCode = substr($rekening->jenis ?? '', 0, 1);
        return in_array($jenisCode, ['1', '5']); // Assets and Expenses are debit accounts
    }

    public function exportToPdf(): void
    {
        try {
            $bukuBesar = $this->calculateBukuBesar();

            // Store data in session for PDF controller
            session([
                'buku_besar_data' => $bukuBesar,
                'buku_besar_params' => [
                    'tanggal_mulai' => $this->tanggal_mulai,
                    'tanggal_akhir' => $this->tanggal_akhir,
                    'masjid_id' => $this->masjid_id,
                    'rekening_id' => $this->rekening_id
                ]
            ]);

            // Redirect to PDF generation route
            redirect()->to('/laporan-buku-besar-pdf');
        } catch (\Exception $e) {
            Notification::make()
                ->title('Gagal Export PDF')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
