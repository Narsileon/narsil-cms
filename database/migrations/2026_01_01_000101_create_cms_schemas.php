<?php

declare(strict_types=1);

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

#endregion

return new class() extends Migration
{
    #region PUBLIC METHODS

    /**
     * @return void
     */
    public function up(): void
    {
        DB::statement('CREATE SCHEMA IF NOT EXISTS cms');
    }

    /**
     * @return void
     */
    public function down(): void
    {
        DB::statement('DROP SCHEMA IF EXISTS cms CASCADE');
    }

    #endregion
};
