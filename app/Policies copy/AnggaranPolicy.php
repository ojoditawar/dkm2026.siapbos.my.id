<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Anggaran;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnggaranPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Anggaran');
    }

    public function view(AuthUser $authUser, Anggaran $anggaran): bool
    {
        return $authUser->can('View:Anggaran');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Anggaran');
    }

    public function update(AuthUser $authUser, Anggaran $anggaran): bool
    {
        return $authUser->can('Update:Anggaran');
    }

    public function delete(AuthUser $authUser, Anggaran $anggaran): bool
    {
        return $authUser->can('Delete:Anggaran');
    }

    public function restore(AuthUser $authUser, Anggaran $anggaran): bool
    {
        return $authUser->can('Restore:Anggaran');
    }

    public function forceDelete(AuthUser $authUser, Anggaran $anggaran): bool
    {
        return $authUser->can('ForceDelete:Anggaran');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Anggaran');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Anggaran');
    }

    public function replicate(AuthUser $authUser, Anggaran $anggaran): bool
    {
        return $authUser->can('Replicate:Anggaran');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Anggaran');
    }

}