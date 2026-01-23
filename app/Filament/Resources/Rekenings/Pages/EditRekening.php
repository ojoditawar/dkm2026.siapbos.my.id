<?php

namespace App\Filament\Resources\Rekenings\Pages;

use App\Filament\Resources\Rekenings\RekeningResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRekening extends EditRecord
{
    protected static string $resource = RekeningResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
