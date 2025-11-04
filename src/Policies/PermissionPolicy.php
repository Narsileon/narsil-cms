<?php

namespace Narsil\Policies;

#region USE

use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Models\Policies\Permission;
use Narsil\Models\User;
use Narsil\Services\PermissionService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class PermissionPolicy
{
    #region PUBLIC METHODS

    /**
     * Determine whether the user can update the permission.
     *
     * @param User $user
     * @param Permission $model
     *
     * @return boolean
     */
    public function update(User $user, Permission $model): bool
    {
        $permission = PermissionService::getName(Permission::TABLE, PermissionEnum::UPDATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view the permission.
     *
     * @param User $user
     * @param Permission $model
     *
     * @return boolean
     */
    public function view(User $user, Permission $model): bool
    {
        $permission = PermissionService::getName(Permission::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view permissions.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function viewAny(User $user): bool
    {
        $permission = PermissionService::getName(Permission::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    #endregion
}
