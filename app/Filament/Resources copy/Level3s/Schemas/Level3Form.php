<?php

namespace App\Filament\Resources\Level3s\Schemas;

use App\Models\Level1;
use App\Models\Level2;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class Level3Form
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('akun1')
                    ->relationship('level1', 'nama')
                    ->columnSpan('full')
                    ->required()
                    ->live()
                    ->default('4')
                    ->afterStateHydrated(function ($state, $set) {
                        // setiap kali user ganti akun1, simpan ke session
                        session(['level2_akun1' => $state]);
                        $set('level2_id', null);
                    }),
                Select::make('level2_id')
                    ->label('Level 2')
                    ->relationship(
                        name: 'level2',
                        titleAttribute: 'nama',
                        modifyQueryUsing: function ($query, $get) {
                            $akun1 = $get('akun1');
                            if ($akun1) {
                                return $query->where('akun1', $akun1);
                            }
                            return $query->whereRaw('1 = 0'); // Return empty if no akun1 selected
                        }
                    )
                    ->columnSpan('full')
                    ->required()
                    ->disabled(fn($get) => !$get('akun1'))
                    ->placeholder('Pilih Level 1 terlebih dahulu')
                    ->live(),
                TextInput::make('akun3')
                    ->columnSpan('full')
                    ->required(),
                TextInput::make('nama')
                    ->columnSpan('full')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $state, $set) {
                        $set('slug', Str::slug($state));
                    }),
                TextInput::make('slug')
                    ->columnSpan('full')
                    ->required()
                    ->disabled()
                    ->dehydrated()
                    ->hint('Otomatis dibuat dari nama'),
                TextInput::make('keterangan')
                    ->columnSpan('full'),
            ]);
    }
}
