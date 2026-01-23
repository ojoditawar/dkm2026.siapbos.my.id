<?php

namespace App\Filament\Resources\SubDanas\Schemas;

use App\Models\SumberDana;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SubDanaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('sumber')
                    ->options(SumberDana::all()->pluck('nama', 'kode'))
                    ->searchable()
                    ->preload()
                    ->placeholder('Input jenis sumber dana')
                    ->helperText(function () {
                        $lastSumber = session('last_sumber');
                        if ($lastSumber) {
                            $sumberDana = SumberDana::where('kode', $lastSumber)->first();
                            $namaSumber = $sumberDana ? $sumberDana->nama : $lastSumber;
                            return "Menggunakan Sumber Dana tersimpan: {$namaSumber}. Wajib dipilih dan tidak boleh kosong.";
                        }
                        return 'Wajib dipilih dan tidak boleh kosong';
                    })
                    ->default(session('last_sumber'))
                    ->rules(['required', 'exists:sumber_danas,kode'])
                    ->validationMessages([
                        'required' => 'Sumber Dana wajib dipilih',
                        'exists' => 'Sumber Dana yang dipilih tidak valid'
                    ])
                    ->live(),
                TextInput::make('sub')
                    ->maxLength(2)
                    ->required()
                    ->rules([
                        'required',
                        'max:2',
                        function ($attribute, $value, $fail, $get) {
                            $sumber = $get('sumber');
                            if ($sumber && $value) {
                                $exists = \App\Models\SubDana::where('sumber', $sumber)
                                    ->where('sub', $value)
                                    ->exists();
                                
                                if ($exists) {
                                    $sumberDana = \App\Models\SumberDana::where('kode', $sumber)->first();
                                    $namaSumber = $sumberDana ? $sumberDana->nama : $sumber;
                                    $fail("Kombinasi Sumber Dana '{$namaSumber}' dengan Sub Dana '{$value}' sudah ada. Silakan gunakan kode sub yang berbeda.");
                                }
                            }
                        },
                    ])
                    ->validationMessages([
                        'required' => 'Sub Dana wajib diisi',
                        'max' => 'Sub Dana maksimal 2 karakter'
                    ]),
                TextInput::make('nama')
                    ->required(),
                TextInput::make('keterangan'),
            ]);
    }
}
