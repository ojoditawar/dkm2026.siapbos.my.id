<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Pagu;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaguPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Pagu');
    }

    public function view(AuthUser $authUser, Pagu $pagu): bool
    {
        return $authUser->can('View:Pagu');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Pagu');
    }

    public function update(AuthUser $authUser, Pagu $pagu): bool
    {
        return $authUser->can('Update:Pagu');
    }

    public function delete(AuthUser $authUser, Pagu $pagu): bool
    {
        return $authUser->can('Delete:Pagu');
    }

}