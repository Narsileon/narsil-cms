<?php

namespace Narsil\Policies;

#region USE

use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Models\Elements\Field;
use Narsil\Models\User;
use Narsil\Services\PermissionService;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class FieldPolicy
{
    #region PUBLIC METHODS

    /**
     * Determine whether the user can create fields.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function create(User $user): bool
    {
        $permission = PermissionService::getName(Field::TABLE, PermissionEnum::CREATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can delete the field.
     *
     * @param User $user
     * @param Field $model
     *
     * @return boolean
     */
    public function delete(User $user, Field $model): bool
    {
        $permission = PermissionService::getName(Field::TABLE, PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can delete fields.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function deleteAny(User $user): bool
    {
        $permission = PermissionService::getName(Field::TABLE, PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can update the field.
     *
     * @param User $user
     * @param Field $model
     *
     * @return boolean
     */
    public function update(User $user, Field $model): bool
    {
        $permission = PermissionService::getName(Field::TABLE, PermissionEnum::UPDATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view the field.
     *
     * @param User $user
     * @param Field $model
     *
     * @return boolean
     */
    public function view(User $user, Field $model): bool
    {
        $permission = PermissionService::getName(Field::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view fields.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function viewAny(User $user): bool
    {
        $permission = PermissionService::getName(Field::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    #endregion
}
