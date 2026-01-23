<?php

namespace App\Filament\Resources\Tahuns\Pages;

use App\Filament\Resources\Tahuns\TahunResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTahun extends EditRecord
{
    protected static string $resource = TahunResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
