<?php

namespace App\Filament\Resources\Anggarans\Pages;

use App\Filament\Resources\Anggarans\AnggaranResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAnggaran extends CreateRecord
{
    protected static string $resource = AnggaranResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Bersihkan format koma dari field jumlah sebelum disimpan
        if (isset($data['jumlah'])) {
            $data['jumlah'] = (float) str_replace(',', '', (string) $data['jumlah']);
        }
        
        return $data;
    }
}
