<?php

namespace App\Filament\Resources\SalurZakats\Pages;

use App\Filament\Resources\SalurZakats\SalurZakatResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSalurZakat extends EditRecord
{
    protected static string $resource = SalurZakatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
