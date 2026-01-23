<?php

namespace App\Filament\Resources\Akuns\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AkunForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode')->maxLength(1)
                    ->required(),
                TextInput::make('nama')
                    ->required(),
                TextInput::make('keterangan')->maxLength(255),
            ]);
    }
}
