<?php

namespace App\Filament\Resources\SalurZakats\Pages;

use App\Filament\Resources\SalurZakats\SalurZakatResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSalurZakat extends ViewRecord
{
    protected static string $resource = SalurZakatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
