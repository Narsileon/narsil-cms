<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Narsil\Base\Database\Migrations\TanStackTableMigration;
use Narsil\Base\Traits\HasSchemas;

#endregion

return new class extends Migration
{
    use HasSchemas;

    #region PUBLIC METHODS‚

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        foreach ($this->getSchemas() as $schema)
        {
            new TanStackTableMigration($schema)->up();
        };
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        foreach ($this->getSchemas() as $schema)
        {
            new TanStackTableMigration($schema)->down();
        };
    }

    #endregion
};
