<?php

namespace Narsil\Policies;

#region USE

use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Models\Forms\Form;
use Narsil\Models\User;
use Narsil\Services\PermissionService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormPolicy
{
    #region PUBLIC METHODS

    /**
     * Determine whether the user can create forms.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function create(User $user): bool
    {
        $permission = PermissionService::getHandle(Form::TABLE, PermissionEnum::CREATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can delete the form.
     *
     * @param User $user
     * @param Form $model
     *
     * @return boolean
     */
    public function delete(User $user, Form $model): bool
    {
        $permission = PermissionService::getHandle(Form::TABLE, PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can delete forms.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function deleteAny(User $user): bool
    {
        $permission = PermissionService::getHandle(Form::TABLE, PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can update the form.
     *
     * @param User $user
     * @param Form $model
     *
     * @return boolean
     */
    public function update(User $user, Form $model): bool
    {
        $permission = PermissionService::getHandle(Form::TABLE, PermissionEnum::UPDATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view the form.
     *
     * @param User $user
     * @param Form $model
     *
     * @return boolean
     */
    public function view(User $user, Form $model): bool
    {
        $permission = PermissionService::getHandle(Form::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view forms.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function viewAny(User $user): bool
    {
        $permission = PermissionService::getHandle(Form::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    #endregion
}
