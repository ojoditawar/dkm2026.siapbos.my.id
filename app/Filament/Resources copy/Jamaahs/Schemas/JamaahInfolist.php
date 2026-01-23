<?php

namespace App\Filament\Resources\Jamaahs\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class JamaahInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nama'),
                TextEntry::make('alamat'),
                TextEntry::make('telpon'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('pekerjaan')
                    ->badge(),
                TextEntry::make('status'),
                TextEntry::make('foto'),
                TextEntry::make('keterangan'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
