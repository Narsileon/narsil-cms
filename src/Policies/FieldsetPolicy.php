<?php

namespace Narsil\Policies;

#region USE

use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Models\Forms\Fieldset;
use Narsil\Models\User;
use Narsil\Services\PermissionService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldsetPolicy
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
        $permission = PermissionService::getHandle(Fieldset::TABLE, PermissionEnum::CREATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can delete the form fieldset.
     *
     * @param User $user
     * @param Fieldset $model
     *
     * @return boolean
     */
    public function delete(User $user, Fieldset $model): bool
    {
        $permission = PermissionService::getHandle(Fieldset::TABLE, PermissionEnum::DELETE->value);

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
        $permission = PermissionService::getHandle(Fieldset::TABLE, PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can update the form fieldset.
     *
     * @param User $user
     * @param Fieldset $model
     *
     * @return boolean
     */
    public function update(User $user, Fieldset $model): bool
    {
        $permission = PermissionService::getHandle(Fieldset::TABLE, PermissionEnum::UPDATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view the form fieldset.
     *
     * @param User $user
     * @param Fieldset $model
     *
     * @return boolean
     */
    public function view(User $user, Fieldset $model): bool
    {
        $permission = PermissionService::getHandle(Fieldset::TABLE, PermissionEnum::VIEW->value);

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
        $permission = PermissionService::getHandle(Fieldset::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    #endregion
}
