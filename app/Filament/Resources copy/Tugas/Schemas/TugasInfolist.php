<?php

namespace App\Filament\Resources\Tugas\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TugasInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('struktur_kode'),
                TextEntry::make('uraian'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
