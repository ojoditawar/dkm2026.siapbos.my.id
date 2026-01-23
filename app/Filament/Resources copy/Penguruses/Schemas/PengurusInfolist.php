<?php

namespace App\Filament\Resources\Penguruses\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PengurusInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('tahun'),
                TextEntry::make('struktur_id'),
                TextEntry::make('nama'),
                IconEntry::make('status')
                    ->boolean(),
                TextEntry::make('foto')
                    ->placeholder('-'),
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
