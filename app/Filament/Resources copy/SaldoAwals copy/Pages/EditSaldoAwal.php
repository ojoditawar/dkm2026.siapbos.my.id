<?php

namespace App\Filament\Resources\SaldoAwals\Pages;

use App\Filament\Resources\SaldoAwals\SaldoAwalResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSaldoAwal extends EditRecord
{
    protected static string $resource = SaldoAwalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
