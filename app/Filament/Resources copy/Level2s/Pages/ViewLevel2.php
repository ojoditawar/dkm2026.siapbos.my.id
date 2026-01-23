<?php

namespace App\Filament\Resources\Level2s\Pages;

use App\Filament\Resources\Level2s\Level2Resource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLevel2 extends ViewRecord
{
    protected static string $resource = Level2Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
