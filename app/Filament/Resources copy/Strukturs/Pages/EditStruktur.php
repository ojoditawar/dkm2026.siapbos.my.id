<?php

namespace App\Filament\Resources\Strukturs\Pages;

use App\Filament\Resources\Strukturs\StrukturResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditStruktur extends EditRecord
{
    protected static string $resource = StrukturResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
