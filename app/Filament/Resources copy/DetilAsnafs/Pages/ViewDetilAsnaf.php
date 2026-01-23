<?php

namespace App\Filament\Resources\DetilAsnafs\Pages;

use App\Filament\Resources\DetilAsnafs\DetilAsnafResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDetilAsnaf extends ViewRecord
{
    protected static string $resource = DetilAsnafResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
