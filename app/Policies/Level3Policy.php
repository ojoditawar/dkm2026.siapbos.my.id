<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Level3;
use Illuminate\Auth\Access\HandlesAuthorization;

class Level3Policy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Level3');
    }

    public function view(AuthUser $authUser, Level3 $level3): bool
    {
        return $authUser->can('View:Level3');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Level3');
    }

    public function update(AuthUser $authUser, Level3 $level3): bool
    {
        return $authUser->can('Update:Level3');
    }

    public function delete(AuthUser $authUser, Level3 $level3): bool
    {
        return $authUser->can('Delete:Level3');
    }

    public function restore(AuthUser $authUser, Level3 $level3): bool
    {
        return $authUser->can('Restore:Level3');
    }

    public function forceDelete(AuthUser $authUser, Level3 $level3): bool
    {
        return $authUser->can('ForceDelete:Level3');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Level3');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Level3');
    }

    public function replicate(AuthUser $authUser, Level3 $level3): bool
    {
        return $authUser->can('Replicate:Level3');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Level3');
    }

}