<?php

namespace App\Filament\Resources\SumberDanas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SumberDanaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode')->length(2)
                    ->placeholder('Pilih Akun Level 2')
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('nama')
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('keterangan'),
            ]);
    }
}
