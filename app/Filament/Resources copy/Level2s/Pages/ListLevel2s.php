<?php

namespace App\Filament\Resources\Level2s\Pages;

use App\Filament\Resources\Level2s\Level2Resource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;

class ListLevel2s extends ListRecords
{
    protected static string $resource = Level2Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('cetak')
                ->label('Cetak Struktur Akun 2')
                ->icon('heroicon-o-printer')
                ->url(route('level2.print'))
                ->openUrlInNewTab(),
        ];
    }
}
