<?php

namespace Narsil\Cms\Traits\Policies;

#region USE

use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Models\User;
use Narsil\Cms\Services\PermissionService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
trait CreatableTrait
{
    #region PUBLIC METHODS

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @param string $model
     *
     * @return boolean
     */
    public function create(User $user, string $model): bool
    {
        $permission = PermissionService::getHandle($model::TABLE, PermissionEnum::CREATE->value);

        return $user->hasPermission($permission);
    }

    #endregion
}
