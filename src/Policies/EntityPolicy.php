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
     * @param User $user
     *
     * @return boolean
     */
    public function create(User $user): bool
    {
        $permission = PermissionService::getName(Entity::TABLE, PermissionEnum::CREATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * @param User $user
     * @param Entity $model
     *
     * @return boolean
     */
    public function delete(User $user, Entity $model): bool
    {
        $permission = PermissionService::getName(Entity::TABLE, PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * @param User $user
     *
     * @return boolean
     */
    public function deleteAny(User $user): bool
    {
        $permission = PermissionService::getName(Entity::TABLE, PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * @param User $user
     * @param Entity $model
     *
     * @return boolean
     */
    public function update(User $user, Entity $model): bool
    {
        $permission = PermissionService::getName(Entity::TABLE, PermissionEnum::UPDATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * @param User $user
     * @param Entity $model
     *
     * @return boolean
     */
    public function view(User $user, Entity $model): bool
    {
        $permission = PermissionService::getName(Entity::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    /**
     * @param User $user
     *
     * @return boolean
     */
    public function viewAny(User $user): bool
    {
        $permission = PermissionService::getName(Entity::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    #endregion
}
