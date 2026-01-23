<?php

namespace App\Filament\Resources\Pagus\Pages;

use App\Filament\Resources\Pagus\PaguResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreatePagu extends CreateRecord
{
    protected static string $resource = PaguResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();
        $data['user_id'] = $user->id;
        $data['masjid_id'] = $user->masjid_id;

        return $data;
    }
}
