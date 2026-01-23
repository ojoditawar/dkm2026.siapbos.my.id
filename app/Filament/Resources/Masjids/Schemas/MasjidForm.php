<?php

namespace App\Filament\Resources\Masjids\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MasjidForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama'),
                TextInput::make('alamat'),
                FileUpload::make('image')
                    ->image(),
            ]);
    }
}
