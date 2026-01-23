<?php

namespace App\Filament\Resources\Level2s\Pages;

use App\Filament\Resources\Level2s\Level2Resource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditLevel2 extends EditRecord
{
    protected static string $resource = Level2Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
