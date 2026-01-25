<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Masjid;
use Illuminate\Auth\Access\HandlesAuthorization;

class MasjidPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Masjid');
    }

    public function view(AuthUser $authUser, Masjid $masjid): bool
    {
        return $authUser->can('View:Masjid');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Masjid');
    }

    public function update(AuthUser $authUser, Masjid $masjid): bool
    {
        return $authUser->can('Update:Masjid');
    }

    public function delete(AuthUser $authUser, Masjid $masjid): bool
    {
        return $authUser->can('Delete:Masjid');
    }

    public function restore(AuthUser $authUser, Masjid $masjid): bool
    {
        return $authUser->can('Restore:Masjid');
    }

    public function forceDelete(AuthUser $authUser, Masjid $masjid): bool
    {
        return $authUser->can('ForceDelete:Masjid');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Masjid');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Masjid');
    }

    public function replicate(AuthUser $authUser, Masjid $masjid): bool
    {
        return $authUser->can('Replicate:Masjid');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Masjid');
    }

}