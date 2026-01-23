<?php

namespace App\Filament\Resources\Asnafs\Pages;

use App\Filament\Resources\Asnafs\AsnafResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAsnaf extends ViewRecord
{
    protected static string $resource = AsnafResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
