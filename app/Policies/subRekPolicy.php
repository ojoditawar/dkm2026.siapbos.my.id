<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\SubRek;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubRekPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:SubRek');
    }

    public function view(AuthUser $authUser, SubRek $subRek): bool
    {
        return $authUser->can('View:SubRek');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:SubRek');
    }

    public function update(AuthUser $authUser, SubRek $subRek): bool
    {
        return $authUser->can('Update:SubRek');
    }

    public function delete(AuthUser $authUser, SubRek $subRek): bool
    {
        return $authUser->can('Delete:SubRek');
    }

}