<?php

namespace App\Filament\Resources\Rekenings\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;

class RekeningForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('')
                    ->schema([
                        TextInput::make('jenis')
                            ->required()
                            ->formatStateUsing(fn($state) => $state ? substr($state, -2) : '')
                            ->dehydrateStateUsing(fn($state, $get) => $get('kelompok') . '.' . $state),
                        TextInput::make('nama')
                            ->required(),
                    ])->columnSpanFull(),

                //
                Section::make('')
                    ->schema([
                        TableRepeater::make('mappingAkun')
                            // ->label('DAFTAR MAPPING AKUN')
                            ->relationship()
                            ->schema([
                                Select::make('bayar')->label('Cara Bayar')
                                    ->options([
                                        '0' => 'Saldo',
                                        '1' => 'Non Tunai',
                                        '2' => 'Tunai',
                                    ])
                                    ->default('1')
                                    ->required(),
                                Select::make('jurnal')
                                    ->options(function () {
                                        return \App\Models\Rekening::orderBy('jenis')->pluck('nama', 'jenis');
                                    })
                                    ->afterStateUpdated(function ($state, $set) {
                                        if ($state) {
                                            $akun = \App\Models\Rekening::where('jenis', $state)->first();
                                            $set('keterangan', $akun?->nama ?? '');
                                        }
                                    })
                                    ->live()
                                    ->required(),
                                Select::make('kolom')
                                    ->options([
                                        'D' => 'Debet',
                                        'K' => 'Kredit',
                                    ])
                                    ->default('D')
                                    ->required(),
                                TextInput::make('keterangan'),
                            ])
                            ->reorderable()
                            ->cloneable()
                            ->collapsible()
                            ->colStyles([
                                'Cara Bayar' => 'text-align: center; background-color: #ded5a4ff; 
                                                color: #3912d4ff; width: 90px;',
                                'Akun Mapping' => 'text-align: center; background-color: #ded5a4ff; 
                                                color: #3912d4ff; width: 700px;',
                                'Kolom' => 'text-align: center; background-color: #ded5a4ff; 
                                                color: #3912d4ff; width: 90px;',
                                'Nama Akun' => 'text-align: center; background-color: #ded5a4ff; 
                                                color: #3912d4ff; width: 100px;',
                            ])

                    ])->columnSpanFull()
            ]);
    }
}
