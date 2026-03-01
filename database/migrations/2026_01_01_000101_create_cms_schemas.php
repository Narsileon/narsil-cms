<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Narsil\Base\Traits\HasSchemas;

#endregion

return new class extends Migration
{
    use HasSchemas;

    #region PUBLIC METHODS

    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up(): void
    {
        foreach ($this->getSchemas() as $schema)
        {
            DB::statement("CREATE SCHEMA IF NOT EXISTS $schema");
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
            DB::statement("DROP SCHEMA IF EXISTS $schema CASCADE");
        };
    }

    #endregion
};
