<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Rekening;
use Illuminate\Auth\Access\HandlesAuthorization;

class RekeningPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Rekening');
    }

    public function view(AuthUser $authUser, Rekening $rekening): bool
    {
        return $authUser->can('View:Rekening');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Rekening');
    }

    public function update(AuthUser $authUser, Rekening $rekening): bool
    {
        return $authUser->can('Update:Rekening');
    }

    public function delete(AuthUser $authUser, Rekening $rekening): bool
    {
        return $authUser->can('Delete:Rekening');
    }

}