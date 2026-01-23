<?php

namespace App\Filament\Resources\Jamaahs\Pages;

use App\Filament\Resources\Jamaahs\JamaahResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewJamaah extends ViewRecord
{
    protected static string $resource = JamaahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
