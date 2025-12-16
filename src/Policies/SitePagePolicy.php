<?php

namespace Narsil\Policies;

#region USE

use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Models\Sites\SitePage;
use Narsil\Models\User;
use Narsil\Services\PermissionService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitePagePolicy
{
    #region PUBLIC METHODS

    /**
     * Determine whether the user can create site pages.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function create(User $user): bool
    {
        $permission = PermissionService::getHandle(SitePage::TABLE, PermissionEnum::CREATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can delete the site page.
     *
     * @param User $user
     * @param SitePage $model
     *
     * @return boolean
     */
    public function delete(User $user, SitePage $model): bool
    {
        $permission = PermissionService::getHandle(SitePage::TABLE, PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can delete site pages.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function deleteAny(User $user): bool
    {
        $permission = PermissionService::getHandle(SitePage::TABLE, PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can update the site page.
     *
     * @param User $user
     * @param SitePage $model
     *
     * @return boolean
     */
    public function update(User $user, SitePage $model): bool
    {
        $permission = PermissionService::getHandle(SitePage::TABLE, PermissionEnum::UPDATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view the site page.
     *
     * @param User $user
     * @param SitePage $model
     *
     * @return boolean
     */
    public function view(User $user, SitePage $model): bool
    {
        $permission = PermissionService::getHandle(SitePage::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view site pages.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function viewAny(User $user): bool
    {
        $permission = PermissionService::getHandle(SitePage::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    #endregion
}
