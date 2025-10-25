<?php

namespace Narsil\Services;

#region USE

use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;

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
    public static function replicateRole(Role $role): void
    {
        $replicated = $role->replicate();

        $replicated
            ->fill([
                Role::HANDLE => DatabaseService::generateUniqueValue($replicated, Role::HANDLE, $role->{Role::HANDLE}),
            ])
            ->save();

        $replicated
            ->syncPermissions($role->{Role::RELATION_PERMISSIONS}
                ->pluck(Permission::ID));
    }

    #endregion
}
