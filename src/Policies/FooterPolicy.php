<?php

namespace Narsil\Policies;

#region USE

use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Models\Globals\Footer;
use Narsil\Models\User;
use Narsil\Services\PermissionService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterPolicy
{
    #region PUBLIC METHODS

    /**
     * Determine whether the user can create footers.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function create(User $user): bool
    {
        $permission = PermissionService::getName(Footer::TABLE, PermissionEnum::CREATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can delete the footer.
     *
     * @param User $user
     * @param Footer $model
     *
     * @return boolean
     */
    public function delete(User $user, Footer $model): bool
    {
        $permission = PermissionService::getName(Footer::TABLE, PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can delete footers.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function deleteAny(User $user): bool
    {
        $permission = PermissionService::getName(Footer::TABLE, PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can update the footer.
     *
     * @param User $user
     * @param Footer $model
     *
     * @return boolean
     */
    public function update(User $user, Footer $model): bool
    {
        $permission = PermissionService::getName(Footer::TABLE, PermissionEnum::UPDATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view the footer.
     *
     * @param User $user
     * @param Footer $model
     *
     * @return boolean
     */
    public function view(User $user, Footer $model): bool
    {
        $permission = PermissionService::getName(Footer::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view footers.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function viewAny(User $user): bool
    {
        $permission = PermissionService::getName(Footer::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    #endregion
}
