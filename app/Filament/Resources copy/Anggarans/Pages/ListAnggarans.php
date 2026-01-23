<?php

namespace App\Filament\Resources\Anggarans\Pages;

use App\Filament\Resources\Anggarans\AnggaranResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;

class ListAnggarans extends ListRecords
{
    protected static string $resource = AnggaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('cetak')
                ->label('Cetak Anggaran')
                ->icon('heroicon-o-printer')
                ->url(route('anggaran.print'))
                ->openUrlInNewTab(),
        ];
    }
}
