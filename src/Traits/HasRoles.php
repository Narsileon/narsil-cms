<?php

namespace Narsil\Traits;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Narsil\Models\Policies\Role;

#endregion

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

    #region RELATIONSHIPS

    /**
     * Get the associated roles.
     *
     * @return BelongsToMany
     */
    abstract public function roles(): BelongsToMany;

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
            $hasRole = $this->{self::RELATION_ROLES}->contains(Role::NAME, $roles);
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

    #endregion

    #region PRIVATE METHODS

    /**
     * @param string|integer|array<string|integer> $roles
     *
     * @return array<int>
     */
    private function getRoleIds(string|int|array $roles): array
    {
        if (!is_array($roles))
        {
            $roles = [$roles];
        }

        $names = [];
        $ids = [];

        foreach ($roles as $role)
        {
            if (is_string($role))
            {
                $names[] = $role;
            }
            else if (is_int($role))
            {
                $ids[] = $role;
            }
        }

        if (!empty($names))
        {
            $names = Role::query()
                ->whereIn(Role::NAME, $names)
                ->pluck(Role::ID)
                ->toArray();

            $ids = array_merge($ids, $names);
        }

        return array_values(array_unique($ids));
    }

    #endregion
}
