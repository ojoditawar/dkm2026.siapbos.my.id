<?php

namespace App\Filament\Resources\Buktis\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BuktiInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('anggaran_id')
                    ->numeric(),
                TextEntry::make('nomor'),
                TextEntry::make('tanggal')
                    ->date(),
                TextEntry::make('uraian'),
                TextEntry::make('jumlah'),
                TextEntry::make('keterangan'),
                TextEntry::make('file_bukti'),
                TextEntry::make('kode'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
