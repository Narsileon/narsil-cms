<?php

namespace Narsil\Cms\Services;

#region USE

use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Models\Policies\Permission;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class PermissionService
{
    #region PUBLIC METHODS

    /**
     * @param string $table
     * @param string $permission
     *
     * @return string
     */
    public static function getHandle(string $table, string $permission): string
    {
        return $table . '_' . $permission;
    }

    /**
     * @param string $table
     * @param string $permission
     * @param string|null $locale
     *
     * @return string
     */
    public static function getName(string $table, string $permission, ?string $locale = null): string
    {
        return trans("narsil-cms::permissions.$permission", [
            'model' => ModelService::getModelLabel($table, false, $locale),
            'table' => ModelService::getTableLabel($table, false, $locale),
        ], $locale);
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

        $filteredPermissions = Permission::query()
            ->whereIn(Permission::NAME, $permissions)
            ->pluck(Permission::NAME)
            ->toArray();

        return $filteredPermissions;
    }

    #endregion
}
