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
                                Select::make('tahun')->label('Tahun Anggaran')
                                    ->options(\App\Models\Tahun::all()->pluck('tahun', 'tahun'))
                                    ->columnspanFull()
                                    ->required(),
                                Select::make('rek_id')->label('Nama Akun')
                                    ->relationship('rek', 'nama', fn($query) => $query->whereIn('kode', ['4', '5']))
                                    ->columnspanFull()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, $set) {
                                        $set('sub_rek_id', null);
                                    }),
                                Select::make('sub_rek_id')->label('Kelompok Akun')
                                    ->relationship('subRek', 'nama')
                                    ->required()
                                    ->live()
                                    ->options(function ($get) {
                                        $rek_id = $get('rek_id');
                                        if (!$rek_id) {
                                            return [];
                                        }
                                        return \App\Models\SubRek::where('rek_id', $rek_id)->pluck('nama', 'id');
                                    })
                                    ->afterStateUpdated(function ($state, $set, $get) {
                                        $rek_id = $get('rek_id');

                                        // Jika level1 = '4', set sdana sama dengan level2_id yang dipilih
                                        if ($rek_id == '4') {
                                            $set('rekening_id', $state);
                                        } else {
                                            $set('rekening_id', null);
                                        }
                                    }),
                                Select::make('rekening_id')->label('Jenis Akun')
                                    ->relationship('reken', 'nama')
                                    ->required()
                                    ->options(function ($get) {
                                        $sub_rek_id = $get('sub_rek_id');
                                        if (!$sub_rek_id) {
                                            return [];
                                        }
                                        return \App\Models\Rekening::where('sub_rek_id', $sub_rek_id)->pluck('nama', 'id');
                                    })
                                    ->afterStateUpdated(function ($state, $set) {
                                        if ($state) {
                                            $rekening = \App\Models\Rekening::find($state);
                                            $set('rekening', $rekening ? $rekening->jenis : null);
                                        } else {
                                            $set('rekening', null);
                                        }
                                    })->live(),
                                TextInput::make('rekening')
                                    ->label('Nama Rekening')
                                    ->hiddenOn('create')
                                    ->hiddenOn('edit')
                                    ->dehydrated()
                                    ->columnSpanFull(),
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
                                            $itemFrek = (float) ($item['frek'] ?? 0);
                                            $grandTotal += $itemJumlah * $itemHarga *  $itemFrek;
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
                                                $frekuensi = floatval($get('frek') ?? 1);
                                                $total = $jumlah * $harga * $frekuensi;
                                                $set('total', $total);
                                            }),
                                        TextInput::make('frek')
                                            ->required()
                                            ->default(1)
                                            ->minValue(1)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function ($state, $set, $get) {
                                                $frekuensi = floatval($state) ?? 0;
                                                $jumlah = floatval($get('jumlah') ?? 0);
                                                $harga = $get('harga') ?? 0;
                                                $total = $jumlah * $harga * $frekuensi;
                                                $set('total', $total);
                                            }),
                                        Select::make('satuan')
                                            ->options([
                                                'pcs' => 'Pcs',
                                                'unit' => 'Unit',
                                                'jam' => 'Jam',
                                                'hari' => 'Hari',
                                                'minggu' => 'Minggu',
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
                                                $jumlah = floatval($get('jumlah') ?? 0);
                                                $frekuensi = floatval($get('frek') ?? 1);
                                                $total = $jumlah * $harga * $frekuensi;
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
                                        'jumlah' => 'text-align: center; background-color: #ded5a4ff; color: #3912d4ff; width: 60px;',
                                        'frek' => 'text-align: center; background-color: #ded5a4ff; color: #3912d4ff; width: 60px;',
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
