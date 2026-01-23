<?php

namespace App\Filament\Resources\SumberDanas\Pages;

use App\Filament\Resources\SumberDanas\SumberDanaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSumberDana extends ViewRecord
{
    protected static string $resource = SumberDanaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
