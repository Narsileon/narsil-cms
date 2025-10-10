<?php

namespace Narsil\Traits;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
trait HasPermissions
{
    #region CONSTANTS

    #region • COUNTS

    /**
     * The name of the "permissions" count.
     *
     * @var string
     */
    final public const COUNT_PERMISSIONS = 'permissions_count';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "permissions" relation.
     *
     * @var string
     */
    final public const RELATION_PERMISSIONS = "permissions";

    #endregion

    #endregion

    #region PUBLIC METHODS

    /**
     * @param string|integer|array<string|integer> $permissions
     *
     * @return void
     */
    final public function attachPermissions(string|int|array $permissions): void
    {
        $permissionIds = $this->getPermissionIds($permissions);

        $this->permissions()->attach($permissionIds);
    }

    /**
     * @param string|integer|array<string|integer> $permissions
     *
     * @return void
     */
    final public function detachPermissions(string|int|array $permissions): void
    {
        $permissionIds = $this->getPermissionIds($permissions);

        $this->permissions()->detach($permissionIds);
    }

    /**
     * @param string|integer $permission
     *
     * @return bool
     */
    final public function hasPermission(string|int $permission): bool
    {
        if ($permission = $this->findPermission($permission))
        {
            return $this->hasPermissionViaPermissions($permission) || $this->hasPermissionViaRoles($permission);
        }

        return true;
    }

    /**
     * @param Permission $permission
     *
     * @return bool
     */
    final public function hasPermissionViaPermissions(Permission $permission): bool
    {
        $this->loadMissing(self::RELATION_PERMISSIONS);

        return $this->{self::RELATION_PERMISSIONS}
            ->contains($permission->getKeyName(), $permission->getKey());
    }

    /**
     * @param Permission $permission
     *
     * @return bool
     */
    final public function hasPermissionViaRoles(Permission $permission): bool
    {
        if (!method_exists($this, 'hasRole'))
        {
            return false;
        }

        $roles = $permission->{Permission::RELATION_ROLES}->pluck(Role::HANDLE)->toArray();

        return $this->hasRole($roles);
    }

    /**
     * @param string|integer|array<string|integer> $permissions
     *
     * @return void
     */
    final public function syncPermissions(string|int|array $permissions): void
    {
        $permissionIds = $this->getPermissionIds($permissions);

        $this->permissions()->sync($permissionIds);
    }

    #region • RELATIONSHIPS

    /**
     * Get the associated permissions.
     *
     * @return BelongsToMany
     */
    abstract public function permissions(): BelongsToMany;

    #endregion

    #endregion

    #region PROTECTED METHODS

    /**
     * @param string|integer|array<string|integer> $permissions
     *
     * @return array<int>
     */
    protected function getPermissionIds(array|int|string $permissions): array
    {
        if (!is_array($permissions))
        {
            $permissions = [$permissions];
        }

        $ids = [];
        $names = [];

        foreach ($permissions as $permission)
        {
            if (is_string($permission))
            {
                $names[] = $permission;
            }
            else if (is_int($permission))
            {
                $ids[] = $permission;
            }
        }

        if (!empty($names))
        {
            $names = Permission::query()
                ->whereIn(Permission::NAME, $names)
                ->pluck(Permission::ID)
                ->toArray();

            $ids = array_merge($ids, $names);
        }

        return array_values(array_unique($ids));
    }

    /**
     * @param string|integer $permission
     *
     * @return Permission|null
     */
    protected function findPermission(string|int $permission): ?Permission
    {
        return Permission::query()
            ->where(Permission::NAME, $permission)
            ->orWhere(Permission::ID, $permission)
            ->first();
    }

    #endregion
}
