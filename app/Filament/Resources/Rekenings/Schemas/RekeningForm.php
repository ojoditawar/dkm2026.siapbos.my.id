<?php

namespace App\Filament\Resources\Rekenings\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

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
                            ->required()
                            ->live(),
                    ])->columnSpanFull(),

                //
                // Section::make('')
                //     ->schema([
                //         TableRepeater::make('mappingAkun')
                //             // ->label('DAFTAR MAPPING AKUN')
                //             ->relationship()
                //             ->schema([
                //                 Select::make('bayar')->label('Cara Bayar')
                //                     ->options([
                //                         '0' => 'Saldo',
                //                         '1' => 'Non Tunai',
                //                         '2' => 'Tunai',
                //                     ])
                //                     ->default('1')
                //                     ->required(),
                //                 Select::make('jurnal')
                //                     ->options(function () {
                //                         return \App\Models\Rekening::orderBy('jenis')->pluck('nama', 'jenis');
                //                     })
                //                     ->afterStateUpdated(function ($state, $set) {
                //                         if ($state) {
                //                             $akun = \App\Models\Rekening::where('jenis', $state)->first();
                //                             $set('keterangan', $akun?->nama ?? '');
                //                         }
                //                     })
                //                     ->live()
                //                     ->required(),
                //                 Select::make('kolom')
                //                     ->options([
                //                         'D' => 'Debet',
                //                         'K' => 'Kredit',
                //                     ])
                //                     ->default('D')
                //                     ->required(),
                //                 TextInput::make('keterangan'),
                //             ])
                //             ->reorderable()
                //             ->cloneable()
                //             ->collapsible()
                //             ->colStyles([
                //                 'Cara Bayar' => 'text-align: center; background-color: #ded5a4ff; 
                //                                 color: #3912d4ff; width: 90px;',
                //                 'Akun Mapping' => 'text-align: center; background-color: #ded5a4ff; 
                //                                 color: #3912d4ff; width: 700px;',
                //                 'Kolom' => 'text-align: center; background-color: #ded5a4ff; 
                //                                 color: #3912d4ff; width: 90px;',
                //                 'Nama Akun' => 'text-align: center; background-color: #ded5a4ff; 
                //                                 color: #3912d4ff; width: 100px;',
                //             ])

                //     ])
                //     ->columnSpanFull(),
                //
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Mapping Akun')
                            ->schema([
                                TableRepeater::make('mappingAkun')
                                    // ->label('DAFTAR MAPPING AKUN')
                                    ->relationship()
                                    ->schema([
                                        Select::make('transaksi')->label('Jenis Transaksi')
                                            ->options([
                                                '1' => 'Saldo Awal',
                                                '2' => 'Penerimaan',
                                                '3' => 'Mutasi Kas',
                                                '4' => 'Pengeluaran',
                                                '5' => 'Pungutan Pajak',
                                                '6' => 'Setoran Pajak',
                                            ])
                                            ->default('2')
                                            ->required(),
                                        Select::make('bayar')->label('Cara Bayar')
                                            ->options([
                                                '0' => 'Non Tunai',
                                                '1' => 'Tunai',
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
                                            ->searchable()
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
                                        'transaksi' => 'text-align: center; background-color: #ded5a4ff; 
                                                color: #3912d4ff; width: 200px;',
                                        'bayar' => 'text-align: center; background-color: #ded5a4ff; 
                                                color: #3912d4ff; width: 150px;',
                                        'jurnal' => 'text-align: center; background-color: #ded5a4ff; 
                                                color: #3912d4ff; width: 300px;',
                                        'kolom' => 'text-align: center; background-color: #ded5a4ff; 
                                                color: #3912d4ff; width: 200px;',
                                        'keterangan' => 'text-align: center; background-color: #ded5a4ff; 
                                                color: #3912d4ff; width: 300px;',
                                    ])


                            ]),
                        Tab::make('Rekam Buku Bantu')
                            ->visible(function (callable $get, $record = null) {
                                $nama = $get('nama');
                                // Check current form value or record value for edit mode
                                if (!$nama && $record) {
                                    $nama = $record->nama;
                                }
                                return $nama === 'Kas Kecil (Tunai)';
                            })
                            ->schema([
                                TableRepeater::make('buku')
                                    ->relationship()
                                    ->schema([
                                        // TextInput::make('jenis')
                                        //     ->required()
                                        //     ->formatStateUsing(fn($state) => $state ? substr($state, -2) : '')
                                        //     ->dehydrateStateUsing(fn($state, $get) => $get('kelompok') . '.' . $state),
                                        // TextInput::make('nama')
                                        //     ->required(),
                                        TextInput::make('subjenis')
                                            ->maxLength(2)
                                            ->required(),
                                        TextInput::make('nmsub')
                                            ->required()
                                    ])
                                    ->columns(3),
                            ])
                            ->columnSpanFull(),
                        // ...
                    ])->columnSpanFull()
                //
            ]);
    }
}
