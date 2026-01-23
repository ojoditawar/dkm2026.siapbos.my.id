<?php

namespace App\Filament\Resources\Strukturs\Pages;

use App\Filament\Resources\Strukturs\StrukturResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewStruktur extends ViewRecord
{
    protected static string $resource = StrukturResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
