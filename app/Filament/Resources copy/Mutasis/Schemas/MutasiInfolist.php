<?php

namespace App\Filament\Resources\Mutasis\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MutasiInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('nomor'),
                TextEntry::make('tanggal')
                    ->date(),
                TextEntry::make('uraian'),
                TextEntry::make('kolom'),
                TextEntry::make('file_bukti'),
                IconEntry::make('kode')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
