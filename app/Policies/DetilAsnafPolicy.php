<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\DetilAsnaf;
use Illuminate\Auth\Access\HandlesAuthorization;

class DetilAsnafPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:DetilAsnaf');
    }

    public function view(AuthUser $authUser, DetilAsnaf $detilAsnaf): bool
    {
        return $authUser->can('View:DetilAsnaf');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:DetilAsnaf');
    }

    public function update(AuthUser $authUser, DetilAsnaf $detilAsnaf): bool
    {
        return $authUser->can('Update:DetilAsnaf');
    }

    public function delete(AuthUser $authUser, DetilAsnaf $detilAsnaf): bool
    {
        return $authUser->can('Delete:DetilAsnaf');
    }

    public function restore(AuthUser $authUser, DetilAsnaf $detilAsnaf): bool
    {
        return $authUser->can('Restore:DetilAsnaf');
    }

    public function forceDelete(AuthUser $authUser, DetilAsnaf $detilAsnaf): bool
    {
        return $authUser->can('ForceDelete:DetilAsnaf');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:DetilAsnaf');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:DetilAsnaf');
    }

    public function replicate(AuthUser $authUser, DetilAsnaf $detilAsnaf): bool
    {
        return $authUser->can('Replicate:DetilAsnaf');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:DetilAsnaf');
    }

}