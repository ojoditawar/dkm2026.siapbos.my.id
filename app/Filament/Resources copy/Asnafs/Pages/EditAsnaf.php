<?php

namespace App\Filament\Resources\Asnafs\Pages;

use App\Filament\Resources\Asnafs\AsnafResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAsnaf extends EditRecord
{
    protected static string $resource = AsnafResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
