<?php

namespace App\Filament\Resources\DetilAsnafs\Pages;

use App\Filament\Resources\DetilAsnafs\DetilAsnafResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDetilAsnafs extends ListRecords
{
    protected static string $resource = DetilAsnafResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
