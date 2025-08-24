<?php

namespace Narsil\Policies;

#region USE

use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Models\Elements\Template;
use Narsil\Models\User;
use Narsil\Services\PermissionService;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class TemplatePolicy
{
    #region PUBLIC METHODS

    /**
     * @param User $user
     *
     * @return boolean
     */
    public function create(User $user): bool
    {
        $permission = PermissionService::getName(Template::TABLE, PermissionEnum::CREATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * @param User $user
     * @param Template $model
     *
     * @return boolean
     */
    public function delete(User $user, Template $model): bool
    {
        $permission = PermissionService::getName(Template::TABLE, PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * @param User $user
     *
     * @return boolean
     */
    public function deleteAny(User $user): bool
    {
        $permission = PermissionService::getName(Template::TABLE, PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * @param User $user
     * @param Template $model
     *
     * @return boolean
     */
    public function update(User $user, Template $model): bool
    {
        $permission = PermissionService::getName(Template::TABLE, PermissionEnum::UPDATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * @param User $user
     * @param Template $model
     *
     * @return boolean
     */
    public function view(User $user, Template $model): bool
    {
        $permission = PermissionService::getName(Template::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    /**
     * @param User $user
     *
     * @return boolean
     */
    public function viewAny(User $user): bool
    {
        $permission = PermissionService::getName(Template::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    #endregion
}
