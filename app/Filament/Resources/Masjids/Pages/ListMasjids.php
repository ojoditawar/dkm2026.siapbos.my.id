<?php

namespace App\Filament\Resources\Masjids\Pages;

use App\Filament\Resources\Masjids\MasjidResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMasjids extends ListRecords
{
    protected static string $resource = MasjidResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
