<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\SalurZakat;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalurZakatPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:SalurZakat');
    }

    public function view(AuthUser $authUser, SalurZakat $salurZakat): bool
    {
        return $authUser->can('View:SalurZakat');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:SalurZakat');
    }

    public function update(AuthUser $authUser, SalurZakat $salurZakat): bool
    {
        return $authUser->can('Update:SalurZakat');
    }

    public function delete(AuthUser $authUser, SalurZakat $salurZakat): bool
    {
        return $authUser->can('Delete:SalurZakat');
    }

    public function restore(AuthUser $authUser, SalurZakat $salurZakat): bool
    {
        return $authUser->can('Restore:SalurZakat');
    }

    public function forceDelete(AuthUser $authUser, SalurZakat $salurZakat): bool
    {
        return $authUser->can('ForceDelete:SalurZakat');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:SalurZakat');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:SalurZakat');
    }

    public function replicate(AuthUser $authUser, SalurZakat $salurZakat): bool
    {
        return $authUser->can('Replicate:SalurZakat');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:SalurZakat');
    }

}