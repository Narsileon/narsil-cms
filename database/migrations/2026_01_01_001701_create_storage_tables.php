<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Storages\Media;
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
        if (!Schema::hasTable(Media::TABLE))
        {
            $this->createMediaTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(Media::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Create the media table.
     *
     * @return void
     */
    private function createMediaTable(): void
    {
        Schema::create(Media::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->uuid(Media::UUID)
                ->primary();
            $blueprint
                ->string(Media::DISK);
            $blueprint
                ->string(Media::PATH);
            $blueprint
                ->jsonb(Media::ALT)
                ->nullable();
            $blueprint
                ->timestamps();
        });
    }

    #endregion
};
