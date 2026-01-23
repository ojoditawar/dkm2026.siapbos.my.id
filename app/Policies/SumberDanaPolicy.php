<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\SumberDana;
use Illuminate\Auth\Access\HandlesAuthorization;

class SumberDanaPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:SumberDana');
    }

    public function view(AuthUser $authUser, SumberDana $sumberDana): bool
    {
        return $authUser->can('View:SumberDana');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:SumberDana');
    }

    public function update(AuthUser $authUser, SumberDana $sumberDana): bool
    {
        return $authUser->can('Update:SumberDana');
    }

    public function delete(AuthUser $authUser, SumberDana $sumberDana): bool
    {
        return $authUser->can('Delete:SumberDana');
    }

    public function restore(AuthUser $authUser, SumberDana $sumberDana): bool
    {
        return $authUser->can('Restore:SumberDana');
    }

    public function forceDelete(AuthUser $authUser, SumberDana $sumberDana): bool
    {
        return $authUser->can('ForceDelete:SumberDana');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:SumberDana');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:SumberDana');
    }

    public function replicate(AuthUser $authUser, SumberDana $sumberDana): bool
    {
        return $authUser->can('Replicate:SumberDana');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:SumberDana');
    }

}