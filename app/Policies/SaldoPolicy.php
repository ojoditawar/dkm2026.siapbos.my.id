<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Saldo;
use Illuminate\Auth\Access\HandlesAuthorization;

class SaldoPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Saldo');
    }

    public function view(AuthUser $authUser, Saldo $saldo): bool
    {
        return $authUser->can('View:Saldo');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Saldo');
    }

    public function update(AuthUser $authUser, Saldo $saldo): bool
    {
        return $authUser->can('Update:Saldo');
    }

    public function delete(AuthUser $authUser, Saldo $saldo): bool
    {
        return $authUser->can('Delete:Saldo');
    }

    public function restore(AuthUser $authUser, Saldo $saldo): bool
    {
        return $authUser->can('Restore:Saldo');
    }

    public function forceDelete(AuthUser $authUser, Saldo $saldo): bool
    {
        return $authUser->can('ForceDelete:Saldo');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Saldo');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Saldo');
    }

    public function replicate(AuthUser $authUser, Saldo $saldo): bool
    {
        return $authUser->can('Replicate:Saldo');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Saldo');
    }

}