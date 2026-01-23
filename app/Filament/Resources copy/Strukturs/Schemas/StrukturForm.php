<?php

namespace App\Filament\Resources\Strukturs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;

class StrukturForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            // ->columns(3)
            ->components([
                Fieldset::make('Struktur')
                    ->columns(1)
                    // ->columnSpanFull()
                    ->components([
                        TextInput::make('kode')->columnSpan(1)
                            ->required()
                    ]),
                Fieldset::make('Struktur')
                    ->columns(2)
                    ->components([
                        TextInput::make('nama')->columnSpan(2)
                            ->required(),
                        TextInput::make('keterangan')->columnSpan(3)
                    ])
            ])->columns(3);
    }
}
