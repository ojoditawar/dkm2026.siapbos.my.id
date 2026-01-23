<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Mutasi;
use Illuminate\Auth\Access\HandlesAuthorization;

class MutasiPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Mutasi');
    }

    public function view(AuthUser $authUser, Mutasi $mutasi): bool
    {
        return $authUser->can('View:Mutasi');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Mutasi');
    }

    public function update(AuthUser $authUser, Mutasi $mutasi): bool
    {
        return $authUser->can('Update:Mutasi');
    }

    public function delete(AuthUser $authUser, Mutasi $mutasi): bool
    {
        return $authUser->can('Delete:Mutasi');
    }

    public function restore(AuthUser $authUser, Mutasi $mutasi): bool
    {
        return $authUser->can('Restore:Mutasi');
    }

    public function forceDelete(AuthUser $authUser, Mutasi $mutasi): bool
    {
        return $authUser->can('ForceDelete:Mutasi');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Mutasi');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Mutasi');
    }

    public function replicate(AuthUser $authUser, Mutasi $mutasi): bool
    {
        return $authUser->can('Replicate:Mutasi');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Mutasi');
    }

}