<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Level1;
use Illuminate\Auth\Access\HandlesAuthorization;

class Level1Policy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Level1');
    }

    public function view(AuthUser $authUser, Level1 $level1): bool
    {
        return $authUser->can('View:Level1');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Level1');
    }

    public function update(AuthUser $authUser, Level1 $level1): bool
    {
        return $authUser->can('Update:Level1');
    }

    public function delete(AuthUser $authUser, Level1 $level1): bool
    {
        return $authUser->can('Delete:Level1');
    }

    public function restore(AuthUser $authUser, Level1 $level1): bool
    {
        return $authUser->can('Restore:Level1');
    }

    public function forceDelete(AuthUser $authUser, Level1 $level1): bool
    {
        return $authUser->can('ForceDelete:Level1');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Level1');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Level1');
    }

    public function replicate(AuthUser $authUser, Level1 $level1): bool
    {
        return $authUser->can('Replicate:Level1');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Level1');
    }

}