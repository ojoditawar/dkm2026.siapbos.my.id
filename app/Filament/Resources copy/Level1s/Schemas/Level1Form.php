<?php

namespace App\Filament\Resources\Level1s\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class Level1Form
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('akun1')
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
                TextInput::make('keterangan'),
            ]);
    }
}
