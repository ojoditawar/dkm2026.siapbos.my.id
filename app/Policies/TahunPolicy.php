<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Tahun;
use Illuminate\Auth\Access\HandlesAuthorization;

class TahunPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Tahun');
    }

    public function view(AuthUser $authUser, Tahun $tahun): bool
    {
        return $authUser->can('View:Tahun');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Tahun');
    }

    public function update(AuthUser $authUser, Tahun $tahun): bool
    {
        return $authUser->can('Update:Tahun');
    }

    public function delete(AuthUser $authUser, Tahun $tahun): bool
    {
        return $authUser->can('Delete:Tahun');
    }

}