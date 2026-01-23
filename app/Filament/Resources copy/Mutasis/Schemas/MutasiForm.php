<?php

namespace App\Filament\Resources\Mutasis\Schemas;

use App\Models\Mutasi;
use Coolsam\Flatpickr\Forms\Components\Flatpickr;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MutasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nomor')
                    ->columnSpan(1)
                    ->default(self::generateNomorBukti('mutasi'))
                    ->columnSpanFull()
                    ->required(),
                Flatpickr::make('tanggal')
                    ->clickOpens(true)
                    // ->rangePicker()
                    ->label('Tanggal Transaksi')
                    ->default(now())
                    ->columnSpanFull()
                    ->required(),
                Textarea::make('uraian')
                    ->columnSpanFull()
                    ->required(),
                // TextInput::make('kolom')
                //     ->required(),
                FileUpload::make('file_bukti')
                    ->columnSpanFull(),
                Toggle::make('kode')
                    ->default(true)
                    ->required(),
            ])->columns(4);
    }

    private static function generateNomorBukti(string $jenisTransaksi): string
    {
        // Tentukan prefix berdasarkan jenis transaksi
        $prefix = match ($jenisTransaksi) {
            'mutasi' => 'MUT',
            default => 'MUT'
        };

        // Ambil nomor terakhir dari database untuk prefix yang sama
        $lastBukti = Mutasi::where('nomor', 'like', $prefix . '-%')
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
