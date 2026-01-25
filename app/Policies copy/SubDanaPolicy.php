<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\SubDana;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubDanaPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:SubDana');
    }

    public function view(AuthUser $authUser, SubDana $subDana): bool
    {
        return $authUser->can('View:SubDana');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:SubDana');
    }

    public function update(AuthUser $authUser, SubDana $subDana): bool
    {
        return $authUser->can('Update:SubDana');
    }

    public function delete(AuthUser $authUser, SubDana $subDana): bool
    {
        return $authUser->can('Delete:SubDana');
    }

    public function restore(AuthUser $authUser, SubDana $subDana): bool
    {
        return $authUser->can('Restore:SubDana');
    }

    public function forceDelete(AuthUser $authUser, SubDana $subDana): bool
    {
        return $authUser->can('ForceDelete:SubDana');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:SubDana');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:SubDana');
    }

    public function replicate(AuthUser $authUser, SubDana $subDana): bool
    {
        return $authUser->can('Replicate:SubDana');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:SubDana');
    }

}