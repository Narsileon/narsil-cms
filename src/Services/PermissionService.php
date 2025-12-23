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
     * @param string $model
     * @param string $permission
     * @param string|null $locale
     *
     * @return string
     */
    public static function getName(string $model, string $permission, ?string $locale = null): string
    {
        return trans("narsil::permissions.$permission", [
            'model' => ModelService::getModelLabel($model, false, $locale),
            'table' => ModelService::getTableLabel($model::TABLE, false, $locale),
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
            ->whereIn(PERMISSION::HANDLE, $permissions)
            ->pluck(PERMISSION::HANDLE)
            ->toArray();

        return $filteredPermissions;
    }

    #endregion
}
