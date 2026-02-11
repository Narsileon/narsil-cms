<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Cms\Models\Storages\Asset;

#endregion

return new class extends Migration
{
    #region PUBLIC METHODS

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        if (!Schema::hasTable(Asset::TABLE))
        {
            $this->createAssetsTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(Asset::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the assets table.
     *
     * @return void
     */
    private function createAssetsTable(): void
    {
        Schema::create(Asset::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(Asset::UUID)
                ->primary();
            $blueprint
                ->string(Asset::PATH)
                ->index();
            $blueprint
                ->jsonb(Asset::ALT)
                ->nullable();
            $blueprint
                ->timestamps();
        });
    }

    #endregion
};
