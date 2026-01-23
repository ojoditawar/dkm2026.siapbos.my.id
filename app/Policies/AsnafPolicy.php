<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Asnaf;
use Illuminate\Auth\Access\HandlesAuthorization;

class AsnafPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Asnaf');
    }

    public function view(AuthUser $authUser, Asnaf $asnaf): bool
    {
        return $authUser->can('View:Asnaf');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Asnaf');
    }

    public function update(AuthUser $authUser, Asnaf $asnaf): bool
    {
        return $authUser->can('Update:Asnaf');
    }

    public function delete(AuthUser $authUser, Asnaf $asnaf): bool
    {
        return $authUser->can('Delete:Asnaf');
    }

    public function restore(AuthUser $authUser, Asnaf $asnaf): bool
    {
        return $authUser->can('Restore:Asnaf');
    }

    public function forceDelete(AuthUser $authUser, Asnaf $asnaf): bool
    {
        return $authUser->can('ForceDelete:Asnaf');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Asnaf');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Asnaf');
    }

    public function replicate(AuthUser $authUser, Asnaf $asnaf): bool
    {
        return $authUser->can('Replicate:Asnaf');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Asnaf');
    }

}