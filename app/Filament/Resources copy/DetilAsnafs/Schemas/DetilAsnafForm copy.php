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
                                                Section::make('Nama Jenis Asnaf')
                                                    ->components([
                                                        Select::make('asnaf_id')->label('Kelompok Asnaf')
                                                            ->relationship('asnaf', 'nama', fn($query) => $query->orderBy('nama'))
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
                                                            ->live()
                                                            ->required(),
                                                    ])->columnSpan('full')
                                                    ->description('Jika Peneriman Zakat Bukan Untuk Keperluan Bea Siswa, Pilih Jenis Kategori Umum. Nilai yang dipilih akan tersimpan untuk data selanjutnya.'),
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
                                                    ->label('Jumlah Bantuan')
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
                                Tab::make('Simpan Data')
                                    ->schema([
                                        Section::make('Aksi Penyimpanan')
                                            ->description('Pilih aksi yang ingin dilakukan setelah mengisi semua data')
                                            ->schema([
                                                Placeholder::make('action_buttons')
                                                    ->label('')
                                                    ->content(new \Illuminate\Support\HtmlString('
                                                        <div style="display: flex; flex-direction: column; gap: 12px;">
                                                            <button type="submit" style="width: 100%; background-color: #16a34a; color: white; font-weight: 600; padding: 12px 16px; border-radius: 8px; border: none; cursor: pointer; font-size: 14px;" onmouseover="this.style.backgroundColor=\'#15803d\'" onmouseout="this.style.backgroundColor=\'#16a34a\'">
                                                                💾 Simpan Data
                                                            </button>
                                                            
                                                            <button type="submit" name="createAnother" value="1" style="width: 100%; background-color: #2563eb; color: white; font-weight: 600; padding: 12px 16px; border-radius: 8px; border: none; cursor: pointer; font-size: 14px;" onmouseover="this.style.backgroundColor=\'#1d4ed8\'" onmouseout="this.style.backgroundColor=\'#2563eb\'">
                                                                💾➕ Simpan & Buat Data Baru
                                                            </button>
                                                            
                                                            <button type="button" onclick="history.back()" style="width: 100%; background-color: #6b7280; color: white; font-weight: 600; padding: 12px 16px; border-radius: 8px; border: none; cursor: pointer; font-size: 14px;" onmouseover="this.style.backgroundColor=\'#4b5563\'" onmouseout="this.style.backgroundColor=\'#6b7280\'">
                                                                ❌ Batal
                                                            </button>
                                                        </div>
                                                    '))
                                                    ->columnSpanFull(),
                                            ])
                                            ->columnSpanFull(),
                                    ]),
                            ])->vertical()
                    ])->columnSpan('full'),
            ]);
    }
}
