<?php

namespace App\Filament\Resources\Asnafs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AsnafForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->autofocus()
                    ->columnSpan('full')
                    ->required(),
                TextInput::make('keterangan'),
            ]);
    }
}
