<?php

namespace App\Filament\Resources\Level1s\Pages;

use App\Filament\Resources\Level1s\Level1Resource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLevel1 extends ViewRecord
{
    protected static string $resource = Level1Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
