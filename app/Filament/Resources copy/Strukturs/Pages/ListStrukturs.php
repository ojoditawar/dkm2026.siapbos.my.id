<?php

namespace App\Filament\Resources\Strukturs\Pages;

use App\Filament\Resources\Strukturs\StrukturResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStrukturs extends ListRecords
{
    protected static string $resource = StrukturResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
