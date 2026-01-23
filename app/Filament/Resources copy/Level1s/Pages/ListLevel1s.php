<?php

namespace App\Filament\Resources\Level1s\Pages;

use App\Filament\Resources\Level1s\Level1Resource;
use Filament\Actions\CreateAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListLevel1s extends ListRecords
{
    protected static string $resource = Level1Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('cetak')
                ->label('Cetak Struktur Akun 1')
                ->icon('heroicon-o-printer')
                ->url(route('level1.print')) // route untuk print
                // ->url(fn($record) => route('level1.print', $record)) // route untuk print
                ->openUrlInNewTab(), // buka di tab baru 

        ];
    }
}
