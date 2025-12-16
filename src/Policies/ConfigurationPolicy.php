<?php

namespace Narsil\Policies;

#region USE

use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Models\Configuration;
use Narsil\Models\User;
use Narsil\Services\PermissionService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ConfigurationPolicy
{
    #region PUBLIC METHODS

    /**
     * Determine whether the user can update the configuration.
     *
     * @param User $user
     * @param Configuration $model
     *
     * @return boolean
     */
    public function update(User $user, Configuration $model): bool
    {
        $permission = PermissionService::getHandle(Configuration::TABLE, PermissionEnum::UPDATE->value);

        return $user->hasPermission($permission);
    }

    #endregion
}
