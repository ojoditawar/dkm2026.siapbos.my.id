<?php

namespace App\Filament\Resources\Level1s\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class Level1Infolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('akun1'),
                TextEntry::make('nama'),
                TextEntry::make('slug'),
                TextEntry::make('keterangan')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
