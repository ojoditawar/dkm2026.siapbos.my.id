<?php

namespace App\Filament\Resources\Level3s\Pages;

use App\Filament\Resources\Level3s\Level3Resource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditLevel3 extends EditRecord
{
    protected static string $resource = Level3Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
