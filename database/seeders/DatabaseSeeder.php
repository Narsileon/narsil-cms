<?php

namespace Database\Seeders;

#region USE

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class DatabaseSeeder extends Seeder
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

    protected function createSuperAdminUser(): void
    {
        User::create([
            User::EMAIL => 'admin@narsil.io',
            User::EMAIL_VERIFIED_AT => Carbon::now(),
            User::FIRST_NAME => 'Admin',
            User::LAST_NAME => 'Super',
            User::PASSWORD => '123456789',
        ]);
    }

    #endregion
}
