<?php

namespace App\Filament\Resources\Level3s\Pages;

use App\Filament\Resources\Level3s\Level3Resource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLevel3 extends ViewRecord
{
    protected static string $resource = Level3Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
