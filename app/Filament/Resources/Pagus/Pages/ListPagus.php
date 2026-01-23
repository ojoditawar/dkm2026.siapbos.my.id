<?php

namespace App\Filament\Resources\Pagus\Pages;

use App\Filament\Resources\Pagus\PaguResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPagus extends ListRecords
{
    protected static string $resource = PaguResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('cetak')
                ->label('Cetak Pagu Anggaran')
                ->icon('heroicon-o-printer')
                ->url(route('pagu.print'))
                ->openUrlInNewTab(),
        ];
    }
}
