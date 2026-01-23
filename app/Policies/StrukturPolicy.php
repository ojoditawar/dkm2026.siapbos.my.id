<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Struktur;
use Illuminate\Auth\Access\HandlesAuthorization;

class StrukturPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Struktur');
    }

    public function view(AuthUser $authUser, Struktur $struktur): bool
    {
        return $authUser->can('View:Struktur');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Struktur');
    }

    public function update(AuthUser $authUser, Struktur $struktur): bool
    {
        return $authUser->can('Update:Struktur');
    }

    public function delete(AuthUser $authUser, Struktur $struktur): bool
    {
        return $authUser->can('Delete:Struktur');
    }

    public function restore(AuthUser $authUser, Struktur $struktur): bool
    {
        return $authUser->can('Restore:Struktur');
    }

    public function forceDelete(AuthUser $authUser, Struktur $struktur): bool
    {
        return $authUser->can('ForceDelete:Struktur');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Struktur');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Struktur');
    }

    public function replicate(AuthUser $authUser, Struktur $struktur): bool
    {
        return $authUser->can('Replicate:Struktur');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Struktur');
    }

}