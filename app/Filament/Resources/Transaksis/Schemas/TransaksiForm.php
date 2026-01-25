<?php

namespace App\Filament\Resources\Transaksis\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

use Coolsam\Flatpickr\Forms\Components\Flatpickr;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;

use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;
use Illuminate\Support\Facades\Auth;

class TransaksiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Periode')
                    ->columns(2)
                    ->columnSpanFull()
                    ->collapsible()
                    // ->aside()
                    ->description('Prevent abuse by limiting the number of requests per period')
                    ->components([
                        Select::make('tahun')
                            ->options(function () {
                                return \App\Models\Tahun::all()->pluck('tahun', 'tahun');
                            })
                            ->required()
                            ->label('Tahun Anggaran')
                            ->default(function () {
                                // Auto-select current year or first available year
                                $currentYear = date('Y');
                                $tahun = \App\Models\Tahun::where('tahun', $currentYear)->first();
                                return $tahun?->id ?? \App\Models\Tahun::first()?->id;
                            }),
                        Hidden::make('user_id')
                            ->default(function () {
                                return Auth::id();
                            }),
                        Hidden::make('masjid_id')
                            ->default(function () {
                                $user = Auth::user();
                                // Auto-populate masjid_id from user relation
                                if ($user && $user->masjid_id) {
                                    return $user->masjid_id;
                                }
                                // Fallback to first masjid if user doesn't have masjid_id
                                return \App\Models\Masjid::first()?->id;
                            }),
                        TextInput::make('no_trans')
                            ->default(fn() => \App\Models\Transaksi::generateNoTransaksi(Auth::id()))
                            ->disabled()
                            ->dehydrated()
                            ->required(),
                        Flatpickr::make('tanggal')
                            ->required()
                            ->time(false)
                            ->date(true),
                        Select::make('jenis')->label('Jenis Transaksi')
                            ->options([
                                '1' => 'Saldo Awal',
                                '2' => 'Penerimaan',
                                '3' => 'Mutasi Kas',
                                '4' => 'Pengeluaran',
                                '5' => 'Pungutan Pajak',
                                '6' => 'Setoran Pajak',
                            ])
                            ->default('1')
                            ->required()
                            ->live(),
                        // ->afterStateUpdated(function ($state, $set) {
                        //     // $set('uraian', $state);
                        //     $set('kode_akun', null);
                        // }),
                        Select::make('bayar')->label('Cara Bayar')
                            ->options([
                                '0' => 'Non Tunai',
                                '1' => 'Tunai',
                            ])
                            ->default('1')
                            ->required(),
                        Select::make('rekening')->label('Nama Kode Buku Besar')
                            ->options(function (Get $get) {
                                $jenis = $get('jenis');

                                if (!$jenis) {
                                    return [];
                                }

                                // Mapping jenis transaksi ke prefix yang sesuai
                                $prefixMap = [
                                    '1' => '4', // Saldo Awal -> prefix 1
                                    '2' => '4', // Penerimaan -> prefix 4  
                                    '3' => '1', // Mutasi Kas -> prefix 1
                                    '4' => '5', // Pengeluaran -> prefix 5
                                ];

                                $prefix = $prefixMap[$jenis] ?? null;

                                if (!$prefix) {
                                    return [];
                                }

                                return \App\Models\Rekening::where('jenis', 'like', $prefix . '%')
                                    ->orderBy('jenis')
                                    ->pluck('nama', 'jenis');
                            })
                            ->searchable()
                            ->required()
                            ->reactive()
                            // ->live()
                            ->afterStateUpdated(function ($state, $set, $get) {
                                $jenis = $get('jenis');
                                $bayar = $get('bayar');

                                $bayarText = '';
                                if ($bayar == '1') {
                                    $bayarText = 'Non Tunai';
                                } elseif ($bayar == '2') {
                                    $bayarText = 'Tunai';
                                }

                                // Get account name from kode_akun
                                $akunName = '';
                                if ($state) {
                                    $akun = \App\Models\Rekening::where('jenis', $state)->first();
                                    $akunName = $akun ? $akun->nama : $state;
                                }

                                if ($jenis == '1') {
                                    $uraianText = 'Saldo Awal';
                                    if ($akunName) {
                                        $uraianText .= ' ' . $akunName;
                                    }
                                    if ($bayarText) {
                                        $uraianText .= ' ' . $bayarText;
                                    }
                                    $set('uraian', $uraianText);
                                }
                            }),
                    ]),

                //repeater
                Section::make('')
                    ->schema([
                        TableRepeater::make('detailTransaksi')
                            ->relationship()
                            ->schema([
                                // Flatpickr::make('tanggal'),
                                TextInput::make('uraian')->label('Uraian Transaksi')
                                    ->required()->columns(3),
                                TextInput::make('jumlah')->label('Jumlah Transaksi')
                                    ->required()
                                    ->columns(1)
                                    ->numeric()
                                    ->live(onBlur: true)
                                    ->extraInputAttributes([
                                        'style' => 'text-align: right;',
                                    ])
                                    ->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 0),
                            ])
                            ->cloneable()
                            ->reorderable()
                            ->collapsible()
                            ->colStyles(function () {
                                return [
                                    'uraian' => 'color: #e2e2edff; width: 750px;',
                                    'jumlah' => 'color: #e2e2edff; width: 250px;',

                                ];
                            })
                    ])
                    ->columnSpanFull(),

            ]);
    }
}
