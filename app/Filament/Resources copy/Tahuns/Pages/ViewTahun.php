<?php

namespace App\Filament\Resources\Tahuns\Pages;

use App\Filament\Resources\Tahuns\TahunResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTahun extends ViewRecord
{
    protected static string $resource = TahunResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
