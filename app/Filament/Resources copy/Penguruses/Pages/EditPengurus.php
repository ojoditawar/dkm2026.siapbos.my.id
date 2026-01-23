<?php

namespace App\Filament\Resources\Penguruses\Pages;

use App\Filament\Resources\Penguruses\PengurusResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPengurus extends EditRecord
{
    protected static string $resource = PengurusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
