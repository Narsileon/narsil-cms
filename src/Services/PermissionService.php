<?php

namespace Narsil\Services;

#region USE

use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Models\Policies\Permission;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class PermissionService
{
    #region PUBLIC METHODS

    /**
     * @param string $base
     * @param string $permission
     *
     * @return string
     */
    public static function getName(string $base, string $permission): string
    {
        return $base . '_' . $permission;
    }

    /**
     * @param string $base
     *
     * @return array
     */
    public static function getPermissions(string $base): array
    {
        $permissions = [];

        foreach (PermissionEnum::cases() as $permission)
        {
            $permissions[] = self::getName($base, $permission->value);
        }

        $efilteredPermissions = Permission::query()
            ->whereIn(Permission::HANDLE, $permissions)
            ->pluck(Permission::HANDLE)
            ->toArray();

        return $efilteredPermissions;
    }

    #endregion
}
