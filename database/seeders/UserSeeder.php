<?php

namespace Database\Seeders;

#region USE

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Narsil\Models\User;

#endregion

class UserSeeder extends Seeder
{
    #region PUBLIC METHODS

    /**
     * @return void
     */
    public function run(): void
    {
        $this->createSuperAdminUser();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return User
     */
    protected function createSuperAdminUser(): User
    {
        $user = User::create([
            User::EMAIL => 'admin@narsil.io',
            User::EMAIL_VERIFIED_AT => Carbon::now(),
            User::FIRST_NAME => 'Admin',
            User::LAST_NAME => 'Super',
            User::PASSWORD => '123456789',
        ]);

        $user->attachRoles('super_admin');

        return $user;
    }

    #endregion
}
