<?php

namespace App\Filament\Resources\Level1s\Pages;

use App\Filament\Resources\Level1s\Level1Resource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditLevel1 extends EditRecord
{
    protected static string $resource = Level1Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
