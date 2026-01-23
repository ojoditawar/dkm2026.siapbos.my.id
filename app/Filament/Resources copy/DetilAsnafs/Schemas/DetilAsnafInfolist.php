<?php

namespace App\Filament\Resources\DetilAsnafs\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DetilAsnafInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('asnaf_id')
                    ->numeric(),
                TextEntry::make('nama'),
                TextEntry::make('jenis')
                    ->badge(),
                TextEntry::make('alamat'),
                TextEntry::make('hp')
                    ->placeholder('-'),
                TextEntry::make('ktp')
                    ->placeholder('-'),
                TextEntry::make('rekening')
                    ->placeholder('-'),
                TextEntry::make('bank')
                    ->placeholder('-'),
                TextEntry::make('foto')
                    ->placeholder('-'),
                TextEntry::make('keterangan')
                    ->placeholder('-'),
                IconEntry::make('status')
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
