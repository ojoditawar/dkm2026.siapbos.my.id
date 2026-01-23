<?php

namespace App\Filament\Resources\Buktis\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Radio;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use App\Models\Bukti;
use App\Models\Level2;
// use App\Models\Level3;
use Coolsam\Flatpickr\Forms\Components\Flatpickr;

class BuktiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Radio::make('jenis_transaksi')
                            ->label('Jenis Transaksi')
                            ->options([
                                'penerimaan' => 'Penerimaan',
                                'pengeluaran' => 'Pengeluaran',
                                'mutasi' => 'Mutasi Kas',
                            ])
                            ->inline()
                            ->live() // Membuat radio reaktif
                            ->dehydrated(false) // Tidak disimpan ke database karena field virtual
                            ->afterStateUpdated(function ($state, $set, $record) {
                                // Generate nomor bukti saat jenis transaksi berubah (hanya untuk create mode)
                                if ($state && !$record) {
                                    $set('nomor', self::generateNomorBukti($state));
                                }
                            })
                            ->required(),
                        TextInput::make('nomor')
                            ->label('Nomor Bukti')
                            ->disabled()
                            ->dehydrated()
                            ->placeholder('Nomor akan di-generate otomatis')
                            ->helperText('Nomor bukti akan dibuat otomatis berdasarkan jenis transaksi')
                            ->required(),
                        Flatpickr::make('tanggal')
                            // ->format('Y-m-d')
                            // ->time(true)
                            ->label('Tanggal Transaksi')
                            ->default(now())
                            ->required(),
                        TextInput::make('penerima')
                            ->label(function ($get) {
                                $jenisTransaksi = $get('jenis_transaksi');
                                if ($jenisTransaksi === 'penerimaan') {
                                    return 'Diterima dari';
                                } elseif ($jenisTransaksi === 'pengeluaran') {
                                    return 'Dibayarkan kepada';
                                }
                                return 'Penerima'; // Default label
                            })
                            ->live() // Membuat field reaktif terhadap perubahan jenis_transaksi
                            ->helperText(function ($get) {
                                $jenisTransaksi = $get('jenis_transaksi');
                                if ($jenisTransaksi === 'penerimaan') {
                                    return 'Masukkan nama/instansi yang memberikan uang';
                                } elseif ($jenisTransaksi === 'pengeluaran') {
                                    return 'Masukkan nama/instansi yang menerima pembayaran';
                                }
                                return 'Pilih jenis transaksi terlebih dahulu';
                            })
                            ->required(),
                        Select::make('dana')
                            ->label('Tempat Penyimpanan Kas/Pembayaran Kas')
                            ->options(function ($get) {
                                return Level2::whereHas('level1', function ($query) {
                                    $query->where('akun1', '1');
                                })->orderBy('nama', 'asc')->pluck('nama', 'id');
                            })
                            // ->disabled(fn($get) => !$get('level2_id'))
                            ->preload()
                            ->searchable()
                            ->columnSpanFull()
                            ->required(),
                    ])->columns(1)
                    ->collapsible(),
                //batas
                Section::make('Informasi Uraian Transaksi')
                    ->schema([
                        Select::make('pagudetil_id')
                            ->label('Pilih Anggaran Detail')
                            ->required()
                            ->relationship(
                                'paguDetil',
                                'uraian_detail',
                                fn($query, $get) => $query
                                    ->join('pagus', 'pagu_detils.pagu_id', '=', 'pagus.id')
                                    ->when($get('jenis_transaksi') === 'penerimaan', function ($query) use ($get) {
                                        // Filter berdasarkan jenis transaksi penerimaan
                                        // Sesuaikan kondisi ini dengan kebutuhan Anda
                                        return $query->where('pagus.level1_id', 4); // Contoh: level1_id = 4 untuk penerimaan
                                    })
                                    ->when($get('jenis_transaksi') === 'pengeluaran', function ($query) use ($get) {
                                        // Filter berdasarkan jenis transaksi pengeluaran
                                        return $query->where('pagus.level1_id', 5); // Contoh: level1_id = 5 untuk pengeluaran
                                    })
                                    ->select('pagu_detils.*')
                            )
                            ->getOptionLabelFromRecordUsing(function ($record) {
                                return $record->uraian_detail;
                                // return $record->uraian_detail . ' - Rp ' . number_format($record->harga, 0, '.', ',');
                            })
                            ->live()
                            ->afterStateUpdated(function ($state, $set) {
                                if ($state) {
                                    $paguDetil = \App\Models\PaguDetil::find($state);
                                    if ($paguDetil) {
                                        $set('uraian', $paguDetil->uraian_detail);
                                    }
                                }
                            })
                            ->preload()
                            ->searchable()
                            ->visible(fn($get) => $get('jenis_transaksi') !== null), // Hanya tampil jika jenis transaksi sudah dipilih
                        TextInput::make('uraian')
                            ->label('Uraian Transaksi')
                            ->required(),
                        TextInput::make('jumlah')
                            ->label('Jumlah (Rp)')
                            ->numeric()
                            ->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 0)
                            ->prefix('Rp.')
                            ->required(),
                        TextInput::make('keterangan')
                            ->label('Keterangan'),
                        TextInput::make('file_bukti')
                            ->label('File Bukti'),
                        TextInput::make('kode')
                            ->label('Kode Transaksi')
                    ])->columnSpan(2),
            ])
            ->columns(3);
    }

    /**
     * Generate nomor bukti otomatis berdasarkan jenis transaksi
     */
    private static function generateNomorBukti(string $jenisTransaksi): string
    {
        // Tentukan prefix berdasarkan jenis transaksi
        $prefix = match ($jenisTransaksi) {
            'penerimaan' => 'PEN',
            'pengeluaran' => 'BEL',
            'mutasi' => 'MUT',
            default => 'TRX'
        };

        // Ambil nomor terakhir dari database untuk prefix yang sama
        $lastBukti = Bukti::where('nomor', 'like', $prefix . '-%')
            ->orderBy('nomor', 'desc')
            ->first();

        if ($lastBukti) {
            // Ekstrak nomor dari format PEN-0001 atau BEL-0001
            $lastNumber = (int) substr($lastBukti->nomor, -4);
            $nextNumber = $lastNumber + 1;
        } else {
            // Jika belum ada data, mulai dari 1
            $nextNumber = 1;
        }

        // Format nomor dengan 4 digit (0001, 0002, dst.)
        return $prefix . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
