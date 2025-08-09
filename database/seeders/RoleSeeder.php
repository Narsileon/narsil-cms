<?php

namespace Database\Seeders;

#region USE

use Illuminate\Database\Seeder;
use Narsil\Models\Policies\Role;

#endregion

class RoleSeeder extends Seeder
{
    #region PUBLIC METHODS

    /**
     * @return void
     */
    public function run(): void
    {
        $this->createSuperAdminRole();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return Role
     */
    protected function createSuperAdminRole(): Role
    {
        $role = Role::create([
            Role::HANDLE => 'super_admin',
            Role::NAME => 'Super-Admin',
        ]);

        return $role;
    }

    #endregion
}
