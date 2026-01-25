<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Rek;
use Illuminate\Auth\Access\HandlesAuthorization;

class RekPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Rek');
    }

    public function view(AuthUser $authUser, Rek $rek): bool
    {
        return $authUser->can('View:Rek');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Rek');
    }

    public function update(AuthUser $authUser, Rek $rek): bool
    {
        return $authUser->can('Update:Rek');
    }

    public function delete(AuthUser $authUser, Rek $rek): bool
    {
        return $authUser->can('Delete:Rek');
    }

    public function restore(AuthUser $authUser, Rek $rek): bool
    {
        return $authUser->can('Restore:Rek');
    }

    public function forceDelete(AuthUser $authUser, Rek $rek): bool
    {
        return $authUser->can('ForceDelete:Rek');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Rek');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Rek');
    }

    public function replicate(AuthUser $authUser, Rek $rek): bool
    {
        return $authUser->can('Replicate:Rek');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Rek');
    }

}