<?php

namespace Narsil\Cms\Traits\Policies;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Cms\Models\User;
use Narsil\Cms\Services\PermissionService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
trait IsUpdatable
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
        $permission = PermissionService::getHandle($model->getTable(), AbilityEnum::UPDATE->value);

        return $user->hasPermission($permission);
    }

    #endregion
}
