<?php

namespace Narsil\Policies;

#region USE

use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Models\Forms\Input;
use Narsil\Models\User;
use Narsil\Services\PermissionService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class InputPolicy
{
    #region PUBLIC METHODS

    /**
     * Determine whether the user can create inputs.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function create(User $user): bool
    {
        $permission = PermissionService::getHandle(Input::TABLE, PermissionEnum::CREATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can delete the input.
     *
     * @param User $user
     * @param Input $model
     *
     * @return boolean
     */
    public function delete(User $user, Input $model): bool
    {
        $permission = PermissionService::getHandle(Input::TABLE, PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can delete inputs.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function deleteAny(User $user): bool
    {
        $permission = PermissionService::getHandle(Input::TABLE, PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can update the input.
     *
     * @param User $user
     * @param Input $model
     *
     * @return boolean
     */
    public function update(User $user, Input $model): bool
    {
        $permission = PermissionService::getHandle(Input::TABLE, PermissionEnum::UPDATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view the input.
     *
     * @param User $user
     * @param Input $model
     *
     * @return boolean
     */
    public function view(User $user, Input $model): bool
    {
        $permission = PermissionService::getHandle(Input::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view inputs.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function viewAny(User $user): bool
    {
        $permission = PermissionService::getHandle(Input::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    #endregion
}
