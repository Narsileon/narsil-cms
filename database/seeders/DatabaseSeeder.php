<?php

namespace Database\Seeders;

#region USE

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
        $this->call([
            RoleSeeder::class,
            TemplateSeeder::class,
            UserSeeder::class,
        ]);
    }

    #endregion
}
