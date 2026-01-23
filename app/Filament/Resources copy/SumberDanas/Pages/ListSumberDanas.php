<?php

namespace App\Filament\Resources\SumberDanas\Pages;

use App\Filament\Resources\SumberDanas\SumberDanaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSumberDanas extends ListRecords
{
    protected static string $resource = SumberDanaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
