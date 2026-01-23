<?php

namespace App\Filament\Resources\Reks\Pages;

use App\Filament\Resources\Reks\RekResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRek extends EditRecord
{
    protected static string $resource = RekResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
