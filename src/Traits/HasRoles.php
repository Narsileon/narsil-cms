<?php

namespace Narsil\Traits;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Narsil\Models\Policies\Role;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
trait HasRoles
{
    #region CONSTANTS

    #region • COUNTS

    /**
     * The name of the "roles" count.
     *
     * @var string
     */
    final public const COUNT_ROLES = 'roles_count';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "roles" relation.
     *
     * @var string
     */
    final public const RELATION_ROLES = "roles";

    #endregion

    #endregion

    #region PUBLIC METHODS

    /**
     * @param string|integer|array<string|integer> $roles
     *
     * @return void
     */
    final public function attachRoles(string|int|array $roles): void
    {
        $roleIds = $this->getRoleIds($roles);

        $this->roles()->attach($roleIds);
    }

    /**
     * @param string|integer|array<string|integer> $roles
     *
     * @return void
     */
    final public function detachRoles(string|int|array $roles): void
    {
        $roleIds = $this->getRoleIds($roles);

        $this->roles()->detach($roleIds);
    }

    /**
     * @param string|integer|array<string|integer> $roles
     *
     * @return bool
     */
    final public function hasRole(string|int|array $roles): bool
    {
        $this->loadMissing(self::RELATION_ROLES);

        $hasRole = false;

        if (is_string($roles))
        {
            $hasRole = $this->{self::RELATION_ROLES}->contains(Role::HANDLE, $roles);
        }
        else if (is_int($roles))
        {
            $hasRole = $this->{self::RELATION_ROLES}->contains(Role::ID, $roles);
        }
        else if (is_array($roles))
        {
            foreach ($roles as $role)
            {
                if ($this->hasRole($role))
                {
                    return true;
                }
            }

            return false;
        }

        return $hasRole;
    }

    /**
     * @param string|integer|array<string|integer> $roles
     *
     * @return void
     */
    final public function syncRoles(string|int|array $roles): void
    {
        $roleIds = $this->getRoleIds($roles);

        $this->roles()->sync($roleIds);
    }

    #region • RELATIONSHIPS

    /**
     * Get the associated roles.
     *
     * @return BelongsToMany
     */
    abstract public function roles(): BelongsToMany;

    #endregion

    #endregion

    #region PROTECTED METHODS

    /**
     * @param string|integer|array<string|integer> $roles
     *
     * @return array<int>
     */
    protected function getRoleIds(string|int|array $roles): array
    {
        if (!is_array($roles))
        {
            $roles = [$roles];
        }

        $ids = [];
        $handles = [];

        foreach ($roles as $role)
        {
            if (is_string($role))
            {
                $handles[] = $role;
            }
            else if (is_int($role))
            {
                $ids[] = $role;
            }
        }

        if (!empty($handles))
        {
            $handles = Role::query()
                ->whereIn(Role::HANDLE, $handles)
                ->pluck(Role::ID)
                ->toArray();

            $ids = array_merge($ids, $handles);
        }

        return array_values(array_unique($ids));
    }

    #endregion
}
