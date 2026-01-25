<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignPagePermissions extends Command
{
    protected $signature = 'assign:page-permissions';
    protected $description = 'Assign page permissions to super_admin role';

    public function handle()
    {
        $role = Role::where('name', 'super_admin')->first();

        if (!$role) {
            $this->error('super_admin role not found');
            return;
        }

        $permissions = Permission::whereIn('name', [
            'view_any_laporan::buku::besar',
            'view_laporan::buku::besar',
            'view_any_laporan::neraca::transaksi',
            'view_laporan::neraca::transaksi'
        ])->get();

        if ($permissions->count() === 0) {
            $this->error('No page permissions found');
            return;
        }

        $role->givePermissionTo($permissions);

        $this->info('Permissions assigned to super_admin role:');
        foreach ($permissions as $permission) {
            $this->info("- {$permission->name}");
        }
    }
}
