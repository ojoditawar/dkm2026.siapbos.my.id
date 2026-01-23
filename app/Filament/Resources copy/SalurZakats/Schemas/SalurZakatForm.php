<?php

namespace App\Filament\Resources\SalurZakats\Schemas;


use Jacobtims\InlineDateTimePicker\Forms\Components\InlineDateTimePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;

class SalurZakatForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Salur Zakat')
                    ->schema([
                        TextInput::make('nomor')
                            ->default(fn() => self::generateNomorSalur())
                            ->disabled()
                            ->dehydrated()
                            ->required()->columnSpanFull(),
                        InlineDateTimePicker::make('tanggal')
                            ->time(false)
                            ->label(function ($get) {
                                $tanggal = $get('tanggal');
                                if ($tanggal) {
                                    return 'Tanggal - ' . \Carbon\Carbon::parse($tanggal)->locale('id')->isoFormat('DD MMMM YYYY');
                                }
                                return 'Tanggal - ' . \Carbon\Carbon::now()->locale('id')->isoFormat('DD MMMM YYYY');
                            })
                            ->live()
                            ->required(),
                        Radio::make('jenis')
                            ->options([
                                'UMUM' => 'UMUM',
                                'BEASISWA' => 'BEASISWA',
                            ])
                            ->default('BEASISWA')
                            ->live()
                            ->columnSpan(1),
                    ])
                    ->columns(1)
                    ->columnSpan(1),

                Section::make('Informasi Tambahan')
                    ->schema([
                        TableRepeater::make('details')
                            ->label('Daftar Penerima Santunan')
                            ->relationship('details')
                            ->schema([
                                Select::make('detil_asnaf_id')
                                    ->label('Nama Penerima')
                                    ->required()
                                    ->options(function ($get) {
                                        // Ambil jenis dari parent form
                                        $jenis = $get('../../jenis') ?? 'BEASISWA';

                                        if ($jenis === 'UMUM') {
                                            // Filter untuk data umum
                                            return \App\Models\DetilAsnaf::where('jenis', 'UMUM')
                                                ->orWhere('jenis', 'umum')
                                                ->orWhereNull('jenis')
                                                ->pluck('nama', 'id');
                                        } else {
                                            // Filter untuk data beasiswa (semua selain UMUM)
                                            return \App\Models\DetilAsnaf::where('jenis', '!=', 'UMUM')
                                                ->whereNotNull('jenis')
                                                ->pluck('nama', 'id');
                                        }
                                    })
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->live()
                                    ->afterStateUpdated(function ($state, $set) {
                                        if ($state) {
                                            $detilAsnaf = \App\Models\DetilAsnaf::find($state);
                                            if ($detilAsnaf) {
                                                $set('satuan', $detilAsnaf->satuan);
                                                $set('alamat', $detilAsnaf->alamat);
                                                $set('jenis', $detilAsnaf->jenis);
                                            }
                                        }
                                    }),
                                TextInput::make('jenis')
                                    ->label('Jenis')
                                    ->disabled()
                                    ->dehydrated(),
                                TextInput::make('satuan')
                                    ->label('Jumlah Bantuan')
                                    ->required()
                                    ->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 0)
                                    ->numeric(),
                                TextInput::make('alamat')
                                    ->label('Alamat')
                                    ->disabled()
                                    ->dehydrated(),
                                // TextInput::make('keterangan')
                                //     ->label('Keterangan')
                                //     ->columnSpanFull(),
                            ]),
                        Toggle::make('status')
                            ->default(true)
                            ->required(),
                        TextInput::make('keterangan')
                            ->label('Keterangan')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(3),
            ])->columns(4);
    }

    private static function generateNomorSalur(): string
    {
        // Prefix untuk salur zakat
        $prefix = 'SZ';

        // Ambil tahun dan bulan saat ini
        $tahun = date('Y');
        $bulan = date('m');

        // Format: SZ-YYYY-MM-XXXX
        $formatPrefix = $prefix . '-' . $tahun . '-' . $bulan . '-';

        // Cari nomor urut terakhir untuk bulan ini
        $lastRecord = \App\Models\SalurZakat::where('nomor', 'LIKE', $formatPrefix . '%')
            ->orderBy('nomor', 'desc')
            ->first();

        if ($lastRecord) {
            // Ambil 4 digit terakhir dan tambah 1
            $lastNumber = (int) substr($lastRecord->nomor, -4);
            $nextNumber = $lastNumber + 1;
        } else {
            // Mulai dari 1 jika belum ada
            $nextNumber = 1;
        }

        // Format nomor dengan 4 digit (pad dengan 0)
        $nomorUrut = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        return $formatPrefix . $nomorUrut;
    }
}
