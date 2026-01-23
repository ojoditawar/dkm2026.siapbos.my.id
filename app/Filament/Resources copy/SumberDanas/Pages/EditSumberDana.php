<?php

namespace App\Filament\Resources\SumberDanas\Pages;

use App\Filament\Resources\SumberDanas\SumberDanaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSumberDana extends EditRecord
{
    protected static string $resource = SumberDanaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
