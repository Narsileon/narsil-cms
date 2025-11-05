<?php

namespace Narsil\Policies;

#region USE

use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Models\Globals\Header;
use Narsil\Models\User;
use Narsil\Services\PermissionService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HeaderPolicy
{
    #region PUBLIC METHODS

    /**
     * Determine whether the user can create headers.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function create(User $user): bool
    {
        $permission = PermissionService::getName(Header::TABLE, PermissionEnum::CREATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can delete the header.
     *
     * @param User $user
     * @param Header $model
     *
     * @return boolean
     */
    public function delete(User $user, Header $model): bool
    {
        $permission = PermissionService::getName(Header::TABLE, PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can delete headers.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function deleteAny(User $user): bool
    {
        $permission = PermissionService::getName(Header::TABLE, PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can update the header.
     *
     * @param User $user
     * @param Header $model
     *
     * @return boolean
     */
    public function update(User $user, Header $model): bool
    {
        $permission = PermissionService::getName(Header::TABLE, PermissionEnum::UPDATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view the header.
     *
     * @param User $user
     * @param Header $model
     *
     * @return boolean
     */
    public function view(User $user, Header $model): bool
    {
        $permission = PermissionService::getName(Header::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view headers.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function viewAny(User $user): bool
    {
        $permission = PermissionService::getName(Header::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    #endregion
}
