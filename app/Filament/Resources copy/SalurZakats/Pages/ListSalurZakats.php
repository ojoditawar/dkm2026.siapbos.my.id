<?php

namespace App\Filament\Resources\SalurZakats\Pages;

use App\Filament\Resources\SalurZakats\SalurZakatResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSalurZakats extends ListRecords
{
    protected static string $resource = SalurZakatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
