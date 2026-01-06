<?php

namespace Narsil\Services\Models;

#region USE

use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Services\DatabaseService;

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
                Role::SLUG => DatabaseService::generateUniqueValue($replicated, Role::SLUG, $role->{Role::SLUG}),
            ])
            ->save();

        $replicated->permissions()->sync($role->{Role::RELATION_PERMISSIONS}->pluck(Permission::ID)->toArray());
    }

    #endregion
}
