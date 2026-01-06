<?php

namespace Narsil\Policies;

#region USE

use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Models\Entities\Entity;
use Narsil\Models\User;
use Narsil\Services\PermissionService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
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
    public function create(User $user, string $entity): bool
    {
        $permission = PermissionService::getHandle($entity::TABLE, PermissionEnum::CREATE->value);

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
        $permission = PermissionService::getHandle($model::TABLE, PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can delete entities.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function deleteAny(User $user, string $entity): bool
    {
        $permission = PermissionService::getHandle($entity::TABLE, PermissionEnum::DELETE->value);

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
        $permission = PermissionService::getHandle($model::TABLE, PermissionEnum::UPDATE->value);

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
        $permission = PermissionService::getHandle($model::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view entities.
     *
     * @param User $user
     * @param string $entity
     *
     * @return boolean
     */
    public function viewAny(User $user, string $entity): bool
    {
        $permission = PermissionService::getHandle($entity::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    #endregion
}
