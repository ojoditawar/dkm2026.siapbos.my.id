<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Rekening;
use Illuminate\Auth\Access\HandlesAuthorization;

class RekeningPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Rekening');
    }

    public function view(AuthUser $authUser, Rekening $rekening): bool
    {
        return $authUser->can('View:Rekening');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Rekening');
    }

    public function update(AuthUser $authUser, Rekening $rekening): bool
    {
        return $authUser->can('Update:Rekening');
    }

    public function delete(AuthUser $authUser, Rekening $rekening): bool
    {
        return $authUser->can('Delete:Rekening');
    }

    public function restore(AuthUser $authUser, Rekening $rekening): bool
    {
        return $authUser->can('Restore:Rekening');
    }

    public function forceDelete(AuthUser $authUser, Rekening $rekening): bool
    {
        return $authUser->can('ForceDelete:Rekening');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Rekening');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Rekening');
    }

    public function replicate(AuthUser $authUser, Rekening $rekening): bool
    {
        return $authUser->can('Replicate:Rekening');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Rekening');
    }

}