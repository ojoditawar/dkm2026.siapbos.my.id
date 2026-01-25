<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignPagePermissionsToBendahara extends Command
{
    protected $signature = 'assign:bendahara-permissions';
    protected $description = 'Assign page permissions to Bendahara Umum role';

    public function handle()
    {
        $role = Role::where('name', 'Bendahara Umum')->first();

        if (!$role) {
            $this->error('Bendahara Umum role not found');
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

        $this->info('Permissions assigned to Bendahara Umum role:');
        foreach ($permissions as $permission) {
            $this->info("- {$permission->name}");
        }
    }
}
