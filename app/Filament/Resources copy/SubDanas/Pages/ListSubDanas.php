<?php

namespace App\Filament\Resources\SubDanas\Pages;

use App\Filament\Resources\SubDanas\SubDanaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSubDanas extends ListRecords
{
    protected static string $resource = SubDanaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
