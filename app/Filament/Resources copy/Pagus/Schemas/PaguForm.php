<?php

namespace App\Filament\Resources\Pagus\Schemas;



use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;

class PaguForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Informasi Anggaran')
                            ->schema([
                                Select::make('tahun_id')->label('Tahun Anggaran')
                                    ->relationship('tahun', 'tahun')
                                    ->columnspanFull()
                                    ->required(),
                                Select::make('level1_id')->label('JenisAkun')
                                    ->relationship('level1', 'nama')
                                    ->columnspanFull()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, $set) {
                                        $set('level2_id', null);
                                    }),
                                Select::make('level2_id')->label('Kelompok Akun')
                                    ->relationship('level2', 'nama')
                                    ->required()
                                    ->live()
                                    ->options(function ($get) {
                                        $level1Akun = $get('level1_id');
                                        if (!$level1Akun) {
                                            return [];
                                        }
                                        return \App\Models\Level2::where('akun1', $level1Akun)->pluck('nama', 'id');
                                    })
                                    ->afterStateUpdated(function ($state, $set, $get) {
                                        $level1Value = $get('level1_id');

                                        // Jika level1 = '4', set sdana sama dengan level2_id yang dipilih
                                        if ($level1Value == '4') {
                                            $set('sdana', $state);
                                        } else {
                                            $set('sdana', null);
                                        }
                                    }),
                                Select::make('sdana')->label('Sumber Dana')
                                    // ->relationship('sdana', 'nama')
                                    ->required()
                                    ->options(function ($get) {
                                        $level1Value = $get('level1_id');

                                        // Jika level1 = '5', gunakan akun '4' untuk sumber dana
                                        if ($level1Value == '5') {
                                            $level1Akun = '4';
                                        } else {
                                            $level1Akun = $level1Value;
                                        }

                                        if (!$level1Akun) {
                                            return [];
                                        }

                                        return \App\Models\Level2::where('akun1', $level1Akun)->pluck('nama', 'id');
                                    }),
                                Textarea::make('uraian')
                                    ->label('Uraian Alokasi Anggaran')
                                    ->columnSpanFull(),

                                // TextInput::make('keterangan')
                                //     ->label('Keterangan Tambahan'),

                            ])->columns(1),
                        Tab::make('Informasi Detail Anggaran')
                            ->schema([
                                TableRepeater::make('paguDetils')
                                    ->label('Uraian Detail Anggaran Per Jenis Akun')
                                    ->relationship()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, $set, $get) {
                                        $detailItems = $state ?? [];
                                        $grandTotal = 0;

                                        foreach ($detailItems as $item) {
                                            $itemJumlah = (float) ($item['jumlah'] ?? 0);
                                            $itemHarga = (float) ($item['harga'] ?? 0);
                                            $grandTotal += $itemJumlah * $itemHarga;
                                        }

                                        $set('jumlah', $grandTotal);
                                    })
                                    ->schema([
                                        TextInput::make('uraian_detail')
                                            ->required(),
                                        TextInput::make('jumlah')
                                            ->required()
                                            ->default(1)
                                            ->minValue(1)
                                            ->live(onBlur: true)
                                            // ->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 0)
                                            ->afterStateUpdated(function ($state, $set, $get) {
                                                $jumlah = floatval($state) ?? 0;
                                                $harga = $get('harga') ?? 0;
                                                $total = $jumlah * $harga;
                                                $set('total', $total);
                                            }),
                                        Select::make('satuan')
                                            ->options([
                                                'pcs' => 'Pcs',
                                                'unit' => 'Unit',
                                                'jam' => 'Jam',
                                                'hari' => 'Hari',
                                                'bulan' => 'Bulan',
                                                'tahun' => 'Tahun',
                                            ])
                                            ->required(),
                                        TextInput::make('harga')
                                            ->live(onBlur: true)
                                            ->extraInputAttributes([
                                                'style' => 'text-align: right;',
                                            ])
                                            ->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 0)
                                            ->required()
                                            ->default(0)
                                            // ->reactive()
                                            ->afterStateUpdated(function ($state, $set, $get) {
                                                $harga = floatval($state) ?? 0;
                                                $jumlah = $get('jumlah') ?? 0;
                                                $total = $jumlah * $harga;
                                                $set('total', $total);
                                            }),
                                        TextInput::make('total')
                                            ->extraInputAttributes([
                                                'style' => 'text-align: right;',
                                            ])
                                            ->numeric()
                                            ->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 0)
                                            ->required(),
                                    ])
                                    ->reorderable()
                                    ->cloneable()
                                    ->collapsible()
                                    ->colStyles([
                                        'uraian_detail' => 'text-align: center; background-color: #ded5a4ff; color: #3912d4ff; width: 650px;',
                                        'jumlah' => 'text-align: center; background-color: #ded5a4ff; color: #3912d4ff; width: 90px;',
                                        'satuan' => 'text-align: center; background-color: #ded5a4ff; color: #3912d4ff; width: 200px;',
                                        'harga' => 'text-align: center; background-color: #ded5a4ff; color: #3912d4ff; width: 250px;',
                                        'total' => 'text-align: center; background-color: #ded5a4ff; color: #3912d4ff; width: 250px;',
                                    ])
                                    ->columnSpanFull()
                                    ->addActionLabel('Tambah Item')
                                    ->deleteAction(
                                        fn($action) => $action->requiresConfirmation()
                                    ),

                                TextInput::make('jumlah')
                                    ->label('Total Anggaran')
                                    ->prefix('Rp.')
                                    ->extraInputAttributes([
                                        'style' => 'text-align: right; font-weight: bold; text-size: 30px;',
                                    ])
                                    ->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 0)
                                    ->required()
                                    ->default(0),
                            ]),
                    ])
            ]);
    }
}
