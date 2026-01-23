<?php

namespace App\Filament\Resources\Anggarans\Schemas;

use App\Models\SubDana;
use App\Models\SumberDana;
use Filament\Actions\Action;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\HtmlString;
use Filament\Support\Enums\Alignment;
use Filament\Forms\Components\Repeater\TableColumn;

class AnggaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Anggaran')
                    ->schema([
                        Select::make('tahun_id')
                            ->relationship('tahun', 'tahun')
                            ->required(),
                        Select::make('level1_id')
                            ->relationship('level1', 'nama')
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, $set) {
                                $set('level2_id', null);
                                $set('level3_id', null);
                            }),
                        Select::make('level2_id')
                            ->label('Level 2')
                            ->options(function ($get) {
                                $level1Akun = $get('level1_id');
                                if (!$level1Akun) {
                                    return [];
                                }
                                return \App\Models\Level2::where('akun1', $level1Akun)->pluck('nama', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, $set) {
                                $set('level3_id', null);
                            }),
                        Select::make('level3_id')
                            ->label('Level 3')
                            ->options(function ($get) {
                                $level2Id = $get('level2_id');
                                if (!$level2Id) {
                                    return [];
                                }
                                return \App\Models\Level3::where('level2_id', $level2Id)->pluck('nama', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('sumber_dana_id')
                            ->options(function ($get) {
                                return SumberDana::pluck('nama', 'id');
                            })
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

                                // Filter sub dana berdasarkan kode sumber dana (case insensitive & trim)
                                $kode = trim($sumberDana->kode);
                                $subDanas = SubDana::whereRaw('TRIM(sumber) = ?', [$kode])
                                    ->pluck('nama', 'id');

                                // Fallback: jika tidak ada hasil, coba tanpa case sensitivity
                                if ($subDanas->isEmpty()) {
                                    $subDanas = SubDana::whereRaw('UPPER(TRIM(sumber)) = UPPER(?)', [$kode])
                                        ->pluck('nama', 'id');
                                }

                                return $subDanas;
                            })
                            ->searchable()
                            ->preload()

                            ->required(),
                        TextInput::make('uraian')
                            ->label('Uraian')
                            ->required(),
                    ])->columnSpanFull(),
                Repeater::make('detailItems')
                    ->label('Uraian Detail Anggaran Per Jenis Akun')
                    ->relationship()
                    ->live()
                    ->afterStateUpdated(function ($state, $set, $get) {
                        // Update grand total saat item ditambah/dihapus/diubah
                        $detailItems = $state ?? [];
                        $grandTotal = 0;

                        foreach ($detailItems as $item) {
                            $itemJumlah = (float) ($item['jumlah'] ?? 0);
                            $itemHarga = (float) ($item['harga'] ?? 0);
                            $grandTotal += $itemJumlah * $itemHarga;
                        }

                        $set('jumlah_total',  number_format((float) $grandTotal, 0, '.', ','));
                    })

                    ->table([
                        TableColumn::make('Uraian')->width('50%'),
                        TableColumn::make('Jumlah')->width('5%'),
                        TableColumn::make('Satuan')->width('10%'),
                        TableColumn::make('Harga')->width('15%'),
                        TableColumn::make('Total')->width('20%'),
                        // ->alignment(Alignment::Center),
                    ])
                    // ->compact()
                    ->schema([
                        TextInput::make('uraian_detail')
                            ->required(),
                        TextInput::make('jumlah')
                            ->numeric()
                            ->required()
                            ->default(1)
                            ->minValue(1)
                            ->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 0)
                            ->afterStateUpdated(function ($state, $set, $get) {
                                $jumlah = floatval($state) ?? 0;
                                $harga = $get('harga') ?? 0;
                                $total = $jumlah * $harga;
                                $set('total', $total);
                                // Update grand total - trigger recalculation dari parent
                                $set('../../__trigger_grand_total', time());
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
                            ->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 0)
                            ->required()
                            ->default(0)
                            ->prefix('Rp.')
                            ->afterStateUpdated(function ($state, $set, $get) {
                                $harga = floatval($state) ?? 0;
                                $jumlah = $get('jumlah') ?? 0;
                                $total = $jumlah * $harga;
                                $set('total', $total);
                                // Update grand total - trigger recalculation dari parent
                                $set('../../__trigger_grand_total', time());
                            }),
                        TextInput::make('total')
                            ->numeric()
                            ->prefix('Rp.')
                            ->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 0)
                            ->required(),
                    ])
                    ->columnSpanFull()
                    ->addActionLabel('Tambah Item')
                    ->deleteAction(
                        fn($action) => $action->requiresConfirmation()
                    ),
                \Filament\Forms\Components\Hidden::make('__trigger_grand_total')
                    ->live()
                    // ->reactive()
                    ->afterStateUpdated(function ($state, $set, $get) {
                        // Recalculate grand total saat ada trigger
                        $detailItems = $get('detailItems') ?? [];
                        $grandTotal = 0;

                        foreach ($detailItems as $item) {
                            $itemJumlah = (float) ($item['jumlah'] ?? 0);
                            $itemHarga = (float) ($item['harga'] ?? 0);
                            $grandTotal += $itemJumlah * $itemHarga;
                        }

                        $set('jumlah_total',  number_format((float) $grandTotal, 0, '.', ','));
                    }),
                TextInput::make('jumlah_total')
                    ->label('Jumlah Total Detail')
                    ->disabled()
                    ->prefix('Rp.')
                    // ->columnStart(2)
                    ->columnSpan(1),
                TextInput::make('keterangan')
                    ->label('Keterangan Tambahan')
                    ->columnSpanFull(),
            ]);
    }
}
