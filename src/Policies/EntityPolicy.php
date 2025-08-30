<?php

namespace Narsil\Policies;

#region USE

use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Models\Entities\Entity;
use Narsil\Models\User;
use Narsil\Services\PermissionService;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class EntityPolicy
{
    #region PUBLIC METHODS

    /**
     * Determine whether the user can create entities.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function create(User $user): bool
    {
        $permission = PermissionService::getName(Entity::getTableName(), PermissionEnum::CREATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can delete the entity.
     *
     * @param User $user
     * @param Entity $model
     *
     * @return boolean
     */
    public function delete(User $user, Entity $model): bool
    {
        $permission = PermissionService::getName(Entity::getTableName(), PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can delete entities.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function deleteAny(User $user): bool
    {
        $permission = PermissionService::getName(Entity::getTableName(), PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can update the entity.
     *
     * @param User $user
     * @param Entity $model
     *
     * @return boolean
     */
    public function update(User $user, Entity $model): bool
    {
        $permission = PermissionService::getName(Entity::getTableName(), PermissionEnum::UPDATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view the entity.
     *
     * @param User $user
     * @param Entity $model
     *
     * @return boolean
     */
    public function view(User $user, Entity $model): bool
    {
        $permission = PermissionService::getName(Entity::getTableName(), PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view entities.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function viewAny(User $user): bool
    {
        $permission = PermissionService::getName(Entity::getTableName(), PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    #endregion
}
