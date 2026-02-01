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
trait UpdatableTrait
{
    #region PUBLIC METHODS

    /**
     * Determine whether the user can update the block.
     *
     * @param User $user
     * @param Model $model
     *
     * @return boolean
     */
    public function update(User $user, Model $model): bool
    {
        $permission = PermissionService::getHandle($model->getTable(), PermissionEnum::UPDATE->value);

        return $user->hasPermission($permission);
    }

    #endregion
}
