<?php

namespace App\Filament\Resources\SaldoAwals\Schemas;

use App\Models\Level1;
use App\Models\Level2;
use App\Models\Level3;
use App\Models\Tahun;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SaldoAwalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('tahun_id')
                    ->columnSpan(1)
                    ->label('Tahun')
                    ->options(Tahun::all()->pluck('tahun', 'id'))
                    ->required()
                    ->preload()
                    ->searchable()
                    ->columnSpanFull(),
                Select::make('akun1')
                    ->label('Level 1 (Akun)')
                    ->options(Level1::all()->pluck('nama', 'akun1'))
                    ->live() // Membuat field reaktif
                    ->afterStateUpdated(function ($state, $set) {
                        // Reset level2 dan level3 saat akun1 berubah
                        $set('level2_id', null);
                        $set('level3_id', null);
                    })
                    ->preload()
                    ->searchable()
                    ->columnSpanFull()
                    ->required(),
                Select::make('level2_id')
                    ->label('Level 2 (Kelompok Akun)')
                    ->options(function ($get) {
                        $akun1 = $get('akun1');
                        if (!$akun1) {
                            return [];
                        }
                        return Level2::where('akun1', $akun1)->pluck('nama', 'id');
                    })
                    ->live() // Membuat field reaktif
                    ->afterStateUpdated(function ($state, $set) {
                        // Reset level3 saat level2 berubah
                        $set('level3_id', null);
                    })
                    ->disabled(fn($get) => !$get('akun1'))
                    ->preload()
                    ->searchable()
                    ->columnSpanFull()
                    ->required(),
                Select::make('level3_id')
                    ->label('Level 3 (Jenis Akun)')
                    ->options(function ($get) {
                        $level2Id = $get('level2_id');
                        if (!$level2Id) {
                            return [];
                        }
                        return Level3::where('level2_id', $level2Id)->pluck('nama', 'id');
                    })
                    ->disabled(fn($get) => !$get('level2_id'))
                    ->preload()
                    ->searchable()
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('bank')
                    ->required(),
                TextInput::make('rekening')
                    ->required(),
                TextInput::make('jumlah')
                    ->required()
                    ->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 0)
                    ->numeric()
                    ->default(0),
                TextInput::make('keterangan'),
            ]);
    }
}
