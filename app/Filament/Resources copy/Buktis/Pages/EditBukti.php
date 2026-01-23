<?php

namespace App\Filament\Resources\Buktis\Pages;

use App\Filament\Resources\Buktis\BuktiResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBukti extends EditRecord
{
    protected static string $resource = BuktiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Set jenis_transaksi berdasarkan 3 huruf pertama nomor bukti
        if (isset($data['nomor']) && $data['nomor']) {
            $prefix = strtoupper(substr($data['nomor'], 0, 3));
            if ($prefix === 'PEN') {
                $data['jenis_transaksi'] = 'penerimaan';
            } elseif ($prefix === 'BEL') {
                $data['jenis_transaksi'] = 'pengeluaran';
            }
        }

        return $data;
    }
}
