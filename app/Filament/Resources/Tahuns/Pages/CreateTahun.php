<?php

namespace App\Filament\Resources\Tahuns\Pages;

use App\Filament\Resources\Tahuns\TahunResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions\CreateAction;

class CreateTahun extends CreateRecord
{
    protected static string $resource = TahunResource::class;
    protected static ?string $title = 'Isikan Data Tahun';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         CreateAction::make()->label('Tambah Data'),
    //     ];
    // }
}
