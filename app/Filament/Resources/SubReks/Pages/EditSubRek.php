<?php

namespace App\Filament\Resources\SubReks\Pages;

use App\Filament\Resources\SubReks\SubRekResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSubRek extends EditRecord
{
    protected static string $resource = SubRekResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
