<?php

namespace App\Filament\Resources\Level3s\Pages;

use App\Filament\Resources\Level3s\Level3Resource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;

class ListLevel3s extends ListRecords
{
    protected static string $resource = Level3Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
            Action::make('cetak')
                ->label('Cetak Struktur Akun 3')
                ->icon('heroicon-o-printer')
                ->url(route('level3.print'))
                ->openUrlInNewTab(),
        ];
    }
}
