<?php

namespace App\Filament\Resources\Kelompoks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KelompokForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode')
                    ->required(),
                TextInput::make('nama')
                    ->required(),
                TextInput::make('keterangan'),
            ]);
    }
}
