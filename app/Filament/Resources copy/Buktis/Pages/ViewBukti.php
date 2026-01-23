<?php

namespace App\Filament\Resources\Buktis\Pages;

use App\Filament\Resources\Buktis\BuktiResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBukti extends ViewRecord
{
    protected static string $resource = BuktiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
