<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\PostType;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostTypePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PostType');
    }

    public function view(AuthUser $authUser, PostType $postType): bool
    {
        return $authUser->can('View:PostType');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:PostType');
    }

    public function update(AuthUser $authUser, PostType $postType): bool
    {
        return $authUser->can('Update:PostType');
    }

    public function delete(AuthUser $authUser, PostType $postType): bool
    {
        return $authUser->can('Delete:PostType');
    }

    public function restore(AuthUser $authUser, PostType $postType): bool
    {
        return $authUser->can('Restore:PostType');
    }

    public function forceDelete(AuthUser $authUser, PostType $postType): bool
    {
        return $authUser->can('ForceDelete:PostType');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:PostType');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:PostType');
    }

    public function replicate(AuthUser $authUser, PostType $postType): bool
    {
        return $authUser->can('Replicate:PostType');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:PostType');
    }

}