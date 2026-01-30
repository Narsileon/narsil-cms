<?php

namespace Narsil\Policies;

#region USE

use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Models\Storages\Media;
use Narsil\Models\User;
use Narsil\Services\PermissionService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class MediaPolicy
{
    #region PUBLIC METHODS

    /**
     * Determine whether the user can create files.
     *
     * @param Media $user
     *
     * @return boolean
     */
    public function create(User $user): bool
    {
        $permission = PermissionService::getHandle(Media::TABLE, PermissionEnum::CREATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can delete the file.
     *
     * @param User $user
     * @param Media $model
     *
     * @return boolean
     */
    public function delete(User $user, Media $model): bool
    {
        $permission = PermissionService::getHandle(Media::TABLE, PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can delete files.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function deleteAny(User $user): bool
    {
        $permission = PermissionService::getHandle(Media::TABLE, PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can update the file.
     *
     * @param User $user
     * @param Media $model
     *
     * @return boolean
     */
    public function update(User $user, Media $model): bool
    {
        $permission = PermissionService::getHandle(Media::TABLE, PermissionEnum::UPDATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view the file.
     *
     * @param User $user
     * @param Media $model
     *
     * @return boolean
     */
    public function view(User $user, Media $model): bool
    {
        $permission = PermissionService::getHandle(Media::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view files.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function viewAny(User $user): bool
    {
        $permission = PermissionService::getHandle(Media::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    #endregion
}
