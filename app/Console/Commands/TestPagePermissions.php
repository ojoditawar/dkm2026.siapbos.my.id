<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Filament\Pages\LaporanBukuBesar;
use App\Filament\Pages\LaporanNeracaTransaksi;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class TestPagePermissions extends Command
{
    protected $signature = 'test:page-permissions {user_id?}';
    protected $description = 'Test page permissions for a specific user';

    public function handle()
    {
        $userId = $this->argument('user_id');

        if (!$userId) {
            // Show all users if no ID provided
            $users = User::with('roles')->get();
            $this->info("Available users:");
            foreach ($users as $user) {
                $roles = $user->roles->pluck('name')->join(', ') ?: 'No roles';
                $this->info("ID: {$user->id} | Name: {$user->name} | Roles: {$roles}");
            }
            return;
        }

        $user = User::find($userId);

        if (!$user) {
            $this->error("User with ID {$userId} not found");
            return;
        }

        $this->info("Testing permissions for user: {$user->name} (ID: {$user->id})");
        $this->info("User roles: " . $user->roles->pluck('name')->join(', '));
        $this->info("User permissions: " . $user->getAllPermissions()->pluck('name')->join(', '));

        // Test LaporanBukuBesar
        $this->info("\n--- Testing Laporan Buku Besar ---");
        $canViewBukuBesar = Gate::forUser($user)->allows('viewAny', LaporanBukuBesar::class);
        $this->info("Gate::allows('viewAny', LaporanBukuBesar::class): " . ($canViewBukuBesar ? 'TRUE' : 'FALSE'));

        $hasPermission = $user->can('view_any_laporan::buku::besar');
        $this->info("User->can('view_any_laporan::buku::besar'): " . ($hasPermission ? 'TRUE' : 'FALSE'));

        // Test LaporanNeracaTransaksi
        $this->info("\n--- Testing Laporan Neraca Transaksi ---");
        $canViewNeraca = Gate::forUser($user)->allows('viewAny', LaporanNeracaTransaksi::class);
        $this->info("Gate::allows('viewAny', LaporanNeracaTransaksi::class): " . ($canViewNeraca ? 'TRUE' : 'FALSE'));

        $hasPermissionNeraca = $user->can('view_any_laporan::neraca::transaksi');
        $this->info("User->can('view_any_laporan::neraca::transaksi'): " . ($hasPermissionNeraca ? 'TRUE' : 'FALSE'));
    }
}
