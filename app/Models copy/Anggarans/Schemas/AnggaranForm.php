<?php

namespace App\Filament\Resources\Anggarans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use App\Models\Level2;
use App\Models\Level3;
use App\Models\SubDana;
use App\Models\SumberDana;

class AnggaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('tahun_id')
                    ->relationship('tahun', 'tahun')
                    ->columnSpanFull()
                    ->required(),
                Select::make('level1_id')
                    ->relationship('level1', 'nama')
                    ->columnSpanFull()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, $set) {
                        $set('level2_id', null);
                        $set('level3_id', null);
                    }),
                Select::make('level2_id')
                    ->options(function ($get) {
                        $level1Id = $get('level1_id');
                        if (!$level1Id) {
                            return [];
                        }
                        return Level2::where('akun1', $level1Id)->pluck('nama', 'id');
                    })
                    ->columnSpanFull()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, $set) {
                        $set('level3_id', null);
                    }),
                Select::make('level3_id')
                    ->options(function ($get) {
                        $level2Id = $get('level2_id');
                        if (!$level2Id) {
                            return [];
                        }
                        return Level3::where('level2_id', $level2Id)->pluck('nama', 'id');
                    })
                    ->columnSpanFull()
                    ->required(),
                Select::make('sumber_dana_id')
                    ->options(function ($get) {
                        return SumberDana::pluck('nama', 'id');
                    })
                    ->columnSpanFull()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, $set) {
                        $set('sub_dana_id', null);
                    }),
                Select::make('sub_dana_id')
                    ->options(function ($get) {
                        $sumberDanaId = $get('sumber_dana_id');
                        if (!$sumberDanaId) {
                            return [];
                        }
                        // Ambil kode dari sumber dana yang dipilih
                        $sumberDana = SumberDana::find($sumberDanaId);
                        if (!$sumberDana) {
                            return [];
                        }
                        // Filter sub dana berdasarkan kode sumber dana
                        return SubDana::where('sumber', $sumberDana->kode)->pluck('nama', 'id');
                    })
                    ->columnSpanFull()
                    ->required(),
                Textarea::make('uraian')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('jumlah')
                    ->label('Jumlah')
                    ->required()
                    ->numeric()
                    ->step(0.01)
                    ->inputMode('decimal')
                    ->formatStateUsing(function ($state) {
                        if (!$state) return '';
                        return number_format((float) $state, 2, '.', ',');
                    })
                    ->placeholder('Contoh: 1,000,000.50')
                    ->helperText('Format tampilan menggunakan koma pemisah ribuan.')
                    ->rule('numeric')
                    ->rule('min:0'),
                TextInput::make('keterangan')
                    ->columnSpanFull(),
            ]);
    }
}
