<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Pagu;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaguPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Pagu');
    }

    public function view(AuthUser $authUser, Pagu $pagu): bool
    {
        return $authUser->can('View:Pagu');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Pagu');
    }

    public function update(AuthUser $authUser, Pagu $pagu): bool
    {
        return $authUser->can('Update:Pagu');
    }

    public function delete(AuthUser $authUser, Pagu $pagu): bool
    {
        return $authUser->can('Delete:Pagu');
    }

    public function restore(AuthUser $authUser, Pagu $pagu): bool
    {
        return $authUser->can('Restore:Pagu');
    }

    public function forceDelete(AuthUser $authUser, Pagu $pagu): bool
    {
        return $authUser->can('ForceDelete:Pagu');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Pagu');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Pagu');
    }

    public function replicate(AuthUser $authUser, Pagu $pagu): bool
    {
        return $authUser->can('Replicate:Pagu');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Pagu');
    }

}