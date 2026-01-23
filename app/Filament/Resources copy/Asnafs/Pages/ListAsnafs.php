<?php

namespace App\Filament\Resources\Asnafs\Pages;

use App\Filament\Resources\Asnafs\AsnafResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAsnafs extends ListRecords
{
    protected static string $resource = AsnafResource::class;
    protected static ?string $title = '8 Asnaf Yang berhak Menerima  Zakat';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
