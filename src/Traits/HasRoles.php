<?php

namespace Narsil\Traits;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Narsil\Models\Policies\Role;

#endregion

trait HasRoles
{
    #region CONSTANTS

    /**
     * @var string The name of the "roles" count.
     */
    public const COUNT_ROLES = 'roles_count';

    /**
     * @var string The name of the "roles" relation.
     */
    public const RELATION_ROLES = "roles";

    #endregion

    #region RELATIONS

    /**
     * @return BelongsToMany
     */
    abstract public function roles(): BelongsToMany;

    #endregion

    #region PUBLIC METHODS

    /**
     * @param array<int|string>|int|string $roles
     *
     * @return void
     */
    final public function attachRoles(array|int|string $roles): void
    {
        $roleIds = $this->getRoleIds($roles);

        $this->roles()->attach($roleIds);
    }

    /**
     * @param array<int|string>|int|string $roles
     *
     * @return void
     */
    final public function detachs(array|int|string $roles): void
    {
        $roleIds = $this->getRoleIds($roles);

        $this->roles()->detach($roleIds);
    }

    /**
     * @param int|string $role
     *
     * @return bool
     */
    final public function hasRole(int|string $role): bool
    {
        $this->loadMissing(self::RELATION_ROLES);

        $hasRole = false;

        if (is_int($role))
        {
            $hasRole = $this->{self::RELATION_ROLES}->contains(Role::ID, $role);
        }
        else if (is_string($role))
        {
            $hasRole = $this->{self::RELATION_ROLES}->contains(Role::HANDLE, $role);
        }

        return $hasRole;
    }

    /**
     * @param array<int|string>|int|string $roles
     *
     * @return void
     */
    final public function syncRoles(array|int|string $roles): void
    {
        $roleIds = $this->getRoleIds($roles);

        $this->roles()->sync($roleIds);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @param array<int|string>|int|string $roles
     *
     * @return array<int>
     */
    private function getRoleIds(array|int|string $roles): array
    {
        if (!is_array($roles))
        {
            $roles = [$roles];
        }

        $ids = [];
        $handles = [];

        foreach ($roles as $role)
        {
            if (is_int($role))
            {
                $ids[] = $role;
            }
            else if (is_string($role))
            {
                $handles[] = $role;
            }
        }

        if (!empty($handles))
        {
            $handleIds = Role::query()
                ->whereIn(Role::HANDLE, $handles)
                ->pluck(Role::ID)
                ->toArray();

            $ids = array_merge($ids, $handleIds);
        }

        return array_values(array_unique($ids));
    }

    #endregion
}
