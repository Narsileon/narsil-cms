<?php

namespace Narsil\Cms\Database\Seeders;

#region USE

use Illuminate\Database\Seeder;
use Narsil\Cms\Database\Factories\Templates\ContentTemplate;

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
        ContentTemplate::run();
    }

    #endregion
}
