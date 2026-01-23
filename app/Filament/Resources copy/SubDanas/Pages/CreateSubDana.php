<?php

namespace App\Filament\Resources\SubDanas\Pages;

use App\Filament\Resources\SubDanas\SubDanaResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\QueryException;

class CreateSubDana extends CreateRecord
{
    protected static string $resource = SubDanaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Validasi tambahan sebelum menyimpan
        if (empty($data['sumber'])) {
            $this->halt();
            $this->addError('sumber', 'Sumber Dana wajib dipilih dan tidak boleh kosong');
        }

        if (empty($data['sub'])) {
            $this->halt();
            $this->addError('sub', 'Sub Dana wajib diisi dan tidak boleh kosong');
        }

        // Cek duplikasi kombinasi sumber dan sub
        $exists = \App\Models\SubDana::where('sumber', $data['sumber'])
            ->where('sub', $data['sub'])
            ->exists();

        if ($exists) {
            $sumberDana = \App\Models\SumberDana::where('kode', $data['sumber'])->first();
            $namaSumber = $sumberDana ? $sumberDana->nama : $data['sumber'];
            
            $this->halt();
            
            // Tampilkan notification error yang informatif
            Notification::make()
                ->title('Data Duplikat Ditemukan!')
                ->body("
                    <div class='space-y-2'>
                        <div><strong>Sumber Dana:</strong> {$namaSumber}</div>
                        <div><strong>Sub Dana:</strong> {$data['sub']}</div>
                        <div class='text-sm text-red-600 mt-2'>⚠️ Kombinasi ini sudah ada dalam database. Silakan gunakan kode sub yang berbeda.</div>
                    </div>
                ")
                ->danger()
                ->duration(6000)
                ->icon('heroicon-o-exclamation-triangle')
                ->send();
                
            $this->addError('sub', "Kombinasi Sumber Dana '{$namaSumber}' dengan Sub Dana '{$data['sub']}' sudah ada.");
        }

        return $data;
    }

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        try {
            return parent::handleRecordCreation($data);
        } catch (QueryException $e) {
            // Tangkap database constraint violation
            if ($e->getCode() === '23000' && str_contains($e->getMessage(), 'Duplicate entry')) {
                $sumberDana = \App\Models\SumberDana::where('kode', $data['sumber'])->first();
                $namaSumber = $sumberDana ? $sumberDana->nama : $data['sumber'];
                
                // Tampilkan notification error yang informatif
                Notification::make()
                    ->title('Data Duplikat Terdeteksi!')
                    ->body("
                        <div class='space-y-2'>
                            <div><strong>Sumber Dana:</strong> {$namaSumber}</div>
                            <div><strong>Sub Dana:</strong> {$data['sub']}</div>
                            <div class='text-sm text-red-600 mt-2'>⚠️ Kombinasi ini sudah ada dalam database. Silakan gunakan kode sub yang berbeda.</div>
                        </div>
                    ")
                    ->danger()
                    ->duration(6000)
                    ->icon('heroicon-o-exclamation-triangle')
                    ->send();

                $this->halt();
                $this->addError('sub', "Kombinasi Sumber Dana '{$namaSumber}' dengan Sub Dana '{$data['sub']}' sudah ada.");
                
                return new \App\Models\SubDana(); // Return empty model to prevent further processing
            }
            
            throw $e; // Re-throw jika bukan duplicate entry error
        }
    }
}
