<?php

namespace Narsil\Policies;

#region USE

use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Models\Forms\FormFieldset;
use Narsil\Models\User;
use Narsil\Services\PermissionService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormFieldsetPolicy
{
    #region PUBLIC METHODS

    /**
     * Determine whether the user can create form fieldsets.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function create(User $user): bool
    {
        $permission = PermissionService::getHandle(FormFieldset::TABLE, PermissionEnum::CREATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can delete the form fieldset.
     *
     * @param User $user
     * @param FormFieldset $model
     *
     * @return boolean
     */
    public function delete(User $user, FormFieldset $model): bool
    {
        $permission = PermissionService::getHandle(FormFieldset::TABLE, PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can delete form fieldsets.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function deleteAny(User $user): bool
    {
        $permission = PermissionService::getHandle(FormFieldset::TABLE, PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can update the form fieldset.
     *
     * @param User $user
     * @param FormFieldset $model
     *
     * @return boolean
     */
    public function update(User $user, FormFieldset $model): bool
    {
        $permission = PermissionService::getHandle(FormFieldset::TABLE, PermissionEnum::UPDATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view the form fieldset.
     *
     * @param User $user
     * @param FormFieldset $model
     *
     * @return boolean
     */
    public function view(User $user, FormFieldset $model): bool
    {
        $permission = PermissionService::getHandle(FormFieldset::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view form fieldsets.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function viewAny(User $user): bool
    {
        $permission = PermissionService::getHandle(FormFieldset::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    #endregion
}
