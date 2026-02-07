<?php

namespace Narsil\Cms\Traits\Policies;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Models\User;
use Narsil\Cms\Services\PermissionService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
trait IsDeletable
{
    #region PUBLIC METHODS

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Model $model
     *
     * @return boolean
     */
    public function delete(User $user, Model $model): bool
    {
        $permission = PermissionService::getHandle($model->getTable(), PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can delete models.
     *
     * @param User $user
     * @param string $model
     *
     * @return boolean
     */
    public function deleteAny(User $user, string $model): bool
    {
        $permission = PermissionService::getHandle($model::TABLE, PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    #endregion
}
