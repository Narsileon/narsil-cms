<?php

namespace Narsil\Traits;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Narsil\Models\Policies\Permission;

#endregion

trait HasPermissions
{
    #region CONSTANTS

    /**
     * @var string The name of the "permissions" count.
     */
    public const COUNT_PERMISSIONS = 'permissions_count';

    /**
     * @var string The name of the "permissions" relation.
     */
    public const RELATION_PERMISSIONS = "permissions";

    #endregion

    #region RELATIONS

    /**
     * @return BelongsToMany
     */
    abstract public function permissions(): BelongsToMany;

    #endregion

    #region PUBLIC METHODS

    /**
     * @param array<int|string>|int|string $permissions
     *
     * @return void
     */
    final public function attachPermissions(array|int|string $permissions): void
    {
        $permissionIds = $this->getPermissionIds($permissions);

        $this->permissions()->attach($permissionIds);
    }

    /**
     * @param array<int|string>|int|string $roles
     *
     * @return void
     */
    final public function detachPermissions(array|int|string $permissions): void
    {
        $permissionIds = $this->getPermissionIds($permissions);

        $this->permissions()->detach($permissionIds);
    }

    /**
     * @param int|string $role
     *
     * @return bool
     */
    final public function hasPermission(int|string $permission): bool
    {
        $this->loadMissing(self::RELATION_PERMISSIONS);

        $hasPermission = false;

        if (is_int($permission))
        {
            $hasPermission = $this->{self::RELATION_PERMISSIONS}->contains(Permission::ID, $permission);
        }
        else if (is_string($permission))
        {
            $hasPermission = $this->{self::RELATION_PERMISSIONS}->contains(Permission::HANDLE, $permission);
        }

        return $hasPermission;
    }

    /**
     * @param array<int|string>|int|string $permissions
     *
     * @return void
     */
    final public function syncPermissions(array|int|string $permissions): void
    {
        $permissionIds = $this->getPermissionIds($permissions);

        $this->permissions()->sync($permissionIds);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @param array<int|string>|int|string $permissions
     *
     * @return array<int>
     */
    private function getPermissionIds(array|int|string $permissions): array
    {
        if (!is_array($permissions))
        {
            $permissions = [$permissions];
        }

        $ids = [];
        $handles = [];

        foreach ($permissions as $permission)
        {
            if (is_int($permission))
            {
                $ids[] = $permission;
            }
            else if (is_string($permission))
            {
                $handles[] = $permission;
            }
        }

        if (!empty($handles))
        {
            $handleIds = Permission::query()
                ->whereIn(Permission::HANDLE, $handles)
                ->pluck(Permission::ID)
                ->toArray();

            $ids = array_merge($ids, $handleIds);
        }

        return array_values(array_unique($ids));
    }

    #endregion
}
