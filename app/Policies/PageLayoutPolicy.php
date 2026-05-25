<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\PageLayout;
use Illuminate\Auth\Access\HandlesAuthorization;

class PageLayoutPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PageLayout');
    }

    public function view(AuthUser $authUser, PageLayout $pageLayout): bool
    {
        return $authUser->can('View:PageLayout');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:PageLayout');
    }

    public function update(AuthUser $authUser, PageLayout $pageLayout): bool
    {
        return $authUser->can('Update:PageLayout');
    }

    public function delete(AuthUser $authUser, PageLayout $pageLayout): bool
    {
        return $authUser->can('Delete:PageLayout');
    }

    public function restore(AuthUser $authUser, PageLayout $pageLayout): bool
    {
        return $authUser->can('Restore:PageLayout');
    }

    public function forceDelete(AuthUser $authUser, PageLayout $pageLayout): bool
    {
        return $authUser->can('ForceDelete:PageLayout');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:PageLayout');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:PageLayout');
    }

    public function replicate(AuthUser $authUser, PageLayout $pageLayout): bool
    {
        return $authUser->can('Replicate:PageLayout');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:PageLayout');
    }

}