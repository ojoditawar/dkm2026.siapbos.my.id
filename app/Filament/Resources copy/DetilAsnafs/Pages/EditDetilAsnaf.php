<?php

namespace App\Filament\Resources\DetilAsnafs\Pages;

use App\Filament\Resources\DetilAsnafs\DetilAsnafResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDetilAsnaf extends EditRecord
{
    protected static string $resource = DetilAsnafResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
