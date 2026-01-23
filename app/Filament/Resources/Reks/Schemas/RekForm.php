<?php

namespace App\Filament\Resources\Reks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RekForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode')->maxLength(1)
                    ->required(),
                TextInput::make('nama')
                    ->required(),
            ]);
    }
}
