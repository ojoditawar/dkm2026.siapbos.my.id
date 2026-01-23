<?php

namespace App\Filament\Resources\SubDanas\Pages;

use App\Filament\Resources\SubDanas\SubDanaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSubDana extends ViewRecord
{
    protected static string $resource = SubDanaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
