<?php

namespace App\Filament\Resources\SubReks\Pages;

use App\Filament\Resources\Rekenings\RekeningResource;
use App\Filament\Resources\SubReks\SubRekResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSubReks extends ListRecords
{
    protected static string $resource = SubRekResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
            Action::make('Rekening')
                ->icon('heroicon-o-eye')
                ->url(fn($record) => RekeningResource::getUrl('index', ['record' => $record])),
        ];
    }
}
