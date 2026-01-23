<?php

namespace App\Filament\Resources\Mutasis\Pages;

use App\Filament\Resources\Mutasis\MutasiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMutasis extends ListRecords
{
    protected static string $resource = MutasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
