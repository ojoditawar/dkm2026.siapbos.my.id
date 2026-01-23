<?php

namespace App\Filament\Resources\DetilAsnafs\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;


class DetilAsnafForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Rincian Detil Penerima')
                    ->description('Informasi Detil Penerima')
                    ->components([
                        Tabs::make('Tabs')
                            ->tabs([
                                Tab::make('Biodata Penerima')
                                    // ->icon(Heroicon::Bell)
                                    ->schema([
                                        Section::make()
                                            ->schema([
                                                Section::make()
                                                    ->label('PENGISIAN NAMA DAN JENIS ASNAF')
                                                    ->components([
                                                        Select::make('asnaf_id')->label('Pilih Kelompok Asnaf')
                                                            ->relationship('asnaf', 'nama', fn($query) => $query->orderBy('nama'))
                                                            ->placeholder('Pilih kelompok asnaf yang sesuai')
                                                            ->helperText(
                                                                function ($get) {
                                                                    $asnafId = $get('asnaf_id');
                                                                    if ($asnafId) {
                                                                        $asnaf = \App\Models\Asnaf::find($asnafId);
                                                                        return $asnaf ? $asnaf->keterangan ?? 'Tidak ada keterangan' : 'Pilih asnaf terlebih dahulu';
                                                                    }
                                                                    return 'Pilih kelompok asnaf untuk melihat keterangan';
                                                                }
                                                            )
                                                            // ->helperText('Pilih kategori asnaf berdasarkan jenis penerima zakat')
                                                            ->default(fn() => session('last_asnaf_id'))
                                                            ->afterStateUpdated(function ($state) {
                                                                session(['last_asnaf_id' => $state]);
                                                            })
                                                            ->live()
                                                            ->required(),
                                                        Select::make('jenis')
                                                            ->label('Jenis Asnaf')
                                                            ->options([
                                                                'UMUM' => 'U m u m',
                                                                'SD' => 'S d',
                                                                'SMP' => 'S m p',
                                                                'SMA' => 'S m a',
                                                                'D1' => 'D1',
                                                                'D2' => 'D2',
                                                                'D3' => 'D3',
                                                                'D4' => 'D4',
                                                                'S1' => 'S1',
                                                                'S2' => 'S2',
                                                                'S3' => 'S3',
                                                            ])
                                                            ->default(fn() => session('last_jenis', 'UMUM'))
                                                            ->afterStateUpdated(function ($state) {
                                                                session(['last_jenis' => $state]);
                                                            })
                                                            ->helperText('Jika Peneriman Zakat BUKAN UNTUK Keperluan Bea Siswa, Pilih Jenis Jenis Umum')
                                                            ->live()
                                                            ->required(),
                                                    ])->columnSpan('full'),
                                                TextInput::make('nama')
                                                    ->label('Nama Penerima Zakat')
                                                    ->placeholder('Masukkan nama lengkap penerima zakat...')
                                                    ->columnSpanFull()
                                                    ->autofocus()
                                                    ->required(),
                                                Textarea::make('alamat')->columnSpan('8')
                                                    ->required(),
                                                TextInput::make('hp')->columnSpan('4'),
                                                TextInput::make('satuan')->columnSpan('4')
                                                    ->label('Jumlah Santunan')
                                                    ->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 0)
                                                    ->default(fn() => session('last_satuan'))
                                                    ->afterStateUpdated(function ($state) {
                                                        session(['last_satuan' => $state]);
                                                    })
                                                    ->required(),
                                                FileUpload::make('foto')->columnSpan('full'),
                                            ])->columns(12)
                                    ]),
                                Tab::make('Data Bank')
                                    // ->icon(Heroicon::Bell)
                                    ->schema([
                                        TextInput::make('rekening'),
                                        TextInput::make('bank'),
                                    ]),
                                Tab::make('Validasi dan Informasi Tambahan')
                                    // ->icon(Heroicon::Bell)
                                    ->schema([
                                        TextInput::make('keterangan'),
                                        Toggle::make('status')
                                            ->required(),
                                    ]),
                            ])->vertical()
                    ])->columnSpan('full'),
            ]);
    }
}
