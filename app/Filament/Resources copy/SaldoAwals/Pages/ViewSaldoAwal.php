<?php

namespace App\Filament\Resources\SaldoAwals\Pages;

use App\Filament\Resources\SaldoAwals\SaldoAwalResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSaldoAwal extends ViewRecord
{
    protected static string $resource = SaldoAwalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
