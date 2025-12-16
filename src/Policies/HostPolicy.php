<?php

namespace Narsil\Policies;

#region USE

use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Models\Hosts\Host;
use Narsil\Models\User;
use Narsil\Services\PermissionService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostPolicy
{
    #region PUBLIC METHODS

    /**
     * Determine whether the user can create hosts.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function create(User $user): bool
    {
        $permission = PermissionService::getHandle(Host::TABLE, PermissionEnum::CREATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can delete the host.
     *
     * @param User $user
     * @param Host $model
     *
     * @return boolean
     */
    public function delete(User $user, Host $model): bool
    {
        $permission = PermissionService::getHandle(Host::TABLE, PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can delete hosts.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function deleteAny(User $user): bool
    {
        $permission = PermissionService::getHandle(Host::TABLE, PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can update the host.
     *
     * @param User $user
     * @param Host $model
     *
     * @return boolean
     */
    public function update(User $user, Host $model): bool
    {
        $permission = PermissionService::getHandle(Host::TABLE, PermissionEnum::UPDATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view the host.
     *
     * @param User $user
     * @param Host $model
     *
     * @return boolean
     */
    public function view(User $user, Host $model): bool
    {
        $permission = PermissionService::getHandle(Host::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view hosts.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function viewAny(User $user): bool
    {
        $permission = PermissionService::getHandle(Host::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    #endregion
}
