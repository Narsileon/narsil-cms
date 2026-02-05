<?php

namespace Narsil\Cms\Services\Models;

#region USE

use Narsil\Cms\Models\Policies\Permission;
use Narsil\Cms\Models\Policies\Role;
use Narsil\Cms\Services\DatabaseService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class RoleService
{
    #region PUBLIC METHODS

    /**
     * @param Role $role
     *
     * @return void
     */
    public static function replicate(Role $role): void
    {
        $replicated = $role->replicate();

        $replicated
            ->fill([
                Role::NAME => DatabaseService::generateUniqueValue($replicated, Role::NAME, $role->{Role::NAME}),
            ])
            ->save();

        $replicated->permissions()->sync($role->{Role::RELATION_PERMISSIONS}->pluck(Permission::ID)->toArray());
    }

    #endregion
}
