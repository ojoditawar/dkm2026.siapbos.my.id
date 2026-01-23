<?php

namespace App\Filament\Resources\Mutasis\Pages;

use App\Filament\Resources\Mutasis\MutasiResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMutasi extends ViewRecord
{
    protected static string $resource = MutasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
