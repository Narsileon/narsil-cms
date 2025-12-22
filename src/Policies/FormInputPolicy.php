<?php

namespace Narsil\Policies;

#region USE

use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Models\Forms\FormInput;
use Narsil\Models\User;
use Narsil\Services\PermissionService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormInputPolicy
{
    #region PUBLIC METHODS

    /**
     * Determine whether the user can create form inputs.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function create(User $user): bool
    {
        $permission = PermissionService::getHandle(FormInput::TABLE, PermissionEnum::CREATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can delete the form input.
     *
     * @param User $user
     * @param FormInput $model
     *
     * @return boolean
     */
    public function delete(User $user, FormInput $model): bool
    {
        $permission = PermissionService::getHandle(FormInput::TABLE, PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can delete form inputs.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function deleteAny(User $user): bool
    {
        $permission = PermissionService::getHandle(FormInput::TABLE, PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can update the form input.
     *
     * @param User $user
     * @param FormInput $model
     *
     * @return boolean
     */
    public function update(User $user, FormInput $model): bool
    {
        $permission = PermissionService::getHandle(FormInput::TABLE, PermissionEnum::UPDATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view the form input.
     *
     * @param User $user
     * @param FormInput $model
     *
     * @return boolean
     */
    public function view(User $user, FormInput $model): bool
    {
        $permission = PermissionService::getHandle(FormInput::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view form inputs.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function viewAny(User $user): bool
    {
        $permission = PermissionService::getHandle(FormInput::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    #endregion
}
