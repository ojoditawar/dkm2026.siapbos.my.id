<?php

namespace App\Filament\Resources\Anggarans\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AnggaranInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('tahun_id')
                    ->numeric(),
                TextEntry::make('level1_id')
                    ->placeholder('-'),
                TextEntry::make('level2_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('level3_id')
                    ->numeric(),
                TextEntry::make('sumber_dana_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('sub_dana_id')
                    ->numeric(),
                TextEntry::make('uraian')
                    ->columnSpanFull(),
                TextEntry::make('jumlah')
                    ->numeric(),
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
