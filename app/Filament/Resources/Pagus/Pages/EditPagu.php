<?php

namespace App\Filament\Resources\Pagus\Pages;

use App\Filament\Resources\Pagus\PaguResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditPagu extends EditRecord
{
    protected static string $resource = PaguResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $user = Auth::user();
        $data['user_id'] = $user->id;
        $data['masjid_id'] = $user->masjid_id;

        return $data;
    }
}
