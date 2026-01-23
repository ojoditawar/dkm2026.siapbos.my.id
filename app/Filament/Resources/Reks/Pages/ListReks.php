<?php

namespace App\Filament\Resources\Reks\Pages;

use App\Filament\Resources\Reks\RekResource;
use App\Filament\Resources\SubReks\SubRekResource;
use Filament\Actions\CreateAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListReks extends ListRecords
{
    protected static string $resource = RekResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Tambah Data')
                ->icon('heroicon-o-plus'),
            Action::make('Sub Rekening')
                ->icon('heroicon-o-eye')
                ->url(fn($record) => SubRekResource::getUrl('index', ['record' => $record])),
        ];
    }
}
