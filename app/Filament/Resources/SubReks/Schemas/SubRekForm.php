<?php

namespace App\Filament\Resources\SubReks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SubRekForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode')
                    ->required(),
                TextInput::make('kelompok')
                    ->required(),
                TextInput::make('nama')
                    ->required(),
            ]);
    }
}
