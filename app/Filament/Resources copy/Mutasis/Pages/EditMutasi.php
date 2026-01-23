<?php

namespace App\Filament\Resources\Mutasis\Pages;

use App\Filament\Resources\Mutasis\MutasiResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMutasi extends EditRecord
{
    protected static string $resource = MutasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
