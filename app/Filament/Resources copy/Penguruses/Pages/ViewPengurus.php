<?php

namespace App\Filament\Resources\Penguruses\Pages;

use App\Filament\Resources\Penguruses\PengurusResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPengurus extends ViewRecord
{
    protected static string $resource = PengurusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
