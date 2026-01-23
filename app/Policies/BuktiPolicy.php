<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Bukti;
use Illuminate\Auth\Access\HandlesAuthorization;

class BuktiPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Bukti');
    }

    public function view(AuthUser $authUser, Bukti $bukti): bool
    {
        return $authUser->can('View:Bukti');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Bukti');
    }

    public function update(AuthUser $authUser, Bukti $bukti): bool
    {
        return $authUser->can('Update:Bukti');
    }

    public function delete(AuthUser $authUser, Bukti $bukti): bool
    {
        return $authUser->can('Delete:Bukti');
    }

    public function restore(AuthUser $authUser, Bukti $bukti): bool
    {
        return $authUser->can('Restore:Bukti');
    }

    public function forceDelete(AuthUser $authUser, Bukti $bukti): bool
    {
        return $authUser->can('ForceDelete:Bukti');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Bukti');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Bukti');
    }

    public function replicate(AuthUser $authUser, Bukti $bukti): bool
    {
        return $authUser->can('Replicate:Bukti');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Bukti');
    }

}