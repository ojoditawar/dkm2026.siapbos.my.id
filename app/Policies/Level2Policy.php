<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Level2;
use Illuminate\Auth\Access\HandlesAuthorization;

class Level2Policy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Level2');
    }

    public function view(AuthUser $authUser, Level2 $level2): bool
    {
        return $authUser->can('View:Level2');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Level2');
    }

    public function update(AuthUser $authUser, Level2 $level2): bool
    {
        return $authUser->can('Update:Level2');
    }

    public function delete(AuthUser $authUser, Level2 $level2): bool
    {
        return $authUser->can('Delete:Level2');
    }

    public function restore(AuthUser $authUser, Level2 $level2): bool
    {
        return $authUser->can('Restore:Level2');
    }

    public function forceDelete(AuthUser $authUser, Level2 $level2): bool
    {
        return $authUser->can('ForceDelete:Level2');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Level2');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Level2');
    }

    public function replicate(AuthUser $authUser, Level2 $level2): bool
    {
        return $authUser->can('Replicate:Level2');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Level2');
    }

}