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

}