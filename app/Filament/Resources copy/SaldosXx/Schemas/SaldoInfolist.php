<?php

namespace App\Filament\Resources\Saldos\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SaldoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('tahun_id')
                    ->numeric(),
                TextEntry::make('akun1'),
                TextEntry::make('level2_id')
                    ->numeric(),
                TextEntry::make('level3_id')
                    ->numeric(),
                TextEntry::make('bank')
                    ->placeholder('-'),
                TextEntry::make('rekening')
                    ->placeholder('-'),
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
