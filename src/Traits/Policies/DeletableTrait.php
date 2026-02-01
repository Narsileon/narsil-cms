<?php

namespace Narsil\Traits\Policies;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Models\User;
use Narsil\Services\PermissionService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
trait DeletableTrait
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
