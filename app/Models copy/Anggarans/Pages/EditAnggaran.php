<?php

namespace App\Filament\Resources\Anggarans\Pages;

use App\Filament\Resources\Anggarans\AnggaranResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAnggaran extends EditRecord
{
    protected static string $resource = AnggaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
    
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Bersihkan format koma dari field jumlah sebelum disimpan
        if (isset($data['jumlah'])) {
            $data['jumlah'] = (float) str_replace(',', '', (string) $data['jumlah']);
        }
        
        return $data;
    }
}
