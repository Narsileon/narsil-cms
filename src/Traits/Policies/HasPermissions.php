<?php

namespace Narsil\Cms\Traits\Policies;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Narsil\Cms\Models\Policies\Permission;
use Narsil\Cms\Models\Policies\Role;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
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
    final public const RELATION_PERMISSIONS = 'permissions';

    #endregion

    #endregion

    #region PUBLIC METHODS

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

        $roles = $permission->{Permission::RELATION_ROLES}->pluck(Role::NAME)->toArray();

        return $this->hasRole($roles);
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
     * @param string|integer $permission
     *
     * @return Permission|null
     */
    protected function findPermission(string|int $permission): ?Permission
    {
        return Permission::query()
            ->where(Permission::NAME, $permission)
            ->when(is_int($permission), function ($query) use ($permission)
            {
                $query->orWhere(Permission::ID, $permission);
            })
            ->first();
    }

    #endregion
}
