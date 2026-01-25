<?php

namespace App\Filament\Resources\Transaksis\Pages;

use App\Filament\Resources\Transaksis\TransaksiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListTransaksis extends ListRecords
{
    protected static string $resource = TransaksiResource::class;

    protected function getTableQuery(): Builder
    {
        $query = parent::getTableQuery();

        // Jika bukan super admin, filter hanya transaksi milik user yang login
        $user = Auth::user();
        if ($user && !$user->hasRole('super_admin')) {
            $query->where('user_id', Auth::id());
        }

        return $query;
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
