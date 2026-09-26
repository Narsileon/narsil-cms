<?php

declare(strict_types=1);

#region USE

use Illuminate\Database\Migrations\Migration;
use Narsil\Base\Database\Migrations\TanStackTableMigration;

#endregion

return new class() extends Migration
{
    #region PUBLIC METHODS‚

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        new TanStackTableMigration()->up();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        new TanStackTableMigration()->down();
    }

    #endregion
};
