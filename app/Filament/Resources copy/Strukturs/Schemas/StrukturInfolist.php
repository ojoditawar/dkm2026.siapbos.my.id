<?php

namespace App\Filament\Resources\Strukturs\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class StrukturInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('kode'),
                TextEntry::make('nama'),
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
