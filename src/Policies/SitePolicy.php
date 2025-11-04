<?php

namespace Narsil\Policies;

#region USE

use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Models\Sites\Site;
use Narsil\Models\User;
use Narsil\Services\PermissionService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitePolicy
{
    #region PUBLIC METHODS

    /**
     * Determine whether the user can update the site.
     *
     * @param User $user
     * @param Site $model
     *
     * @return boolean
     */
    public function update(User $user, Site $model): bool
    {
        $permission = PermissionService::getName(Site::VIRTUAL_TABLE, PermissionEnum::UPDATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view the site.
     *
     * @param User $user
     * @param Site $model
     *
     * @return boolean
     */
    public function view(User $user, Site $model): bool
    {
        $permission = PermissionService::getName(Site::VIRTUAL_TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view sites.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function viewAny(User $user): bool
    {
        $permission = PermissionService::getName(Site::VIRTUAL_TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    #endregion
}
