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
trait IsViewable
{
    #region PUBLIC METHODS

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Model $model
     *
     * @return boolean
     */
    public function view(User $user, Model $model): bool
    {
        $permission = PermissionService::getHandle($model->getTable(), PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view models.
     *
     * @param User $user
     * @param string $model
     *
     * @return boolean
     */
    public function viewAny(User $user, string $model): bool
    {
        $permission = PermissionService::getHandle($model::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    #endregion
}
