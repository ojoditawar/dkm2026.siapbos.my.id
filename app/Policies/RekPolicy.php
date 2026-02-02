<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Rek;
use Illuminate\Auth\Access\HandlesAuthorization;

class RekPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Rek');
    }

    public function view(AuthUser $authUser, Rek $rek): bool
    {
        return $authUser->can('View:Rek');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Rek');
    }

    public function update(AuthUser $authUser, Rek $rek): bool
    {
        return $authUser->can('Update:Rek');
    }

    public function delete(AuthUser $authUser, Rek $rek): bool
    {
        return $authUser->can('Delete:Rek');
    }

}