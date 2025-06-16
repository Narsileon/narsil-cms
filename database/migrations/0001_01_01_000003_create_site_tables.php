<?php

#region USE

use App\Models\Cache;
use App\Models\CacheLock;
use App\Models\Sites\Site;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
        if (!Schema::hasTable(Cache::TABLE))
        {
            $this->createSitesTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(Site::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @return void
     */
    private function createSitesTable(): void
    {
        Schema::create(Site::TABLE, function (Blueprint $table)
        {
            $table
                ->id(Site::ID);
            $table
                ->boolean(Site::ENABLED)
                ->default(true);
            $table
                ->string(Site::NAME);
            $table
                ->string(Site::HANDLE);
            $table
                ->string(Site::LANGUAGE);
            $table
                ->boolean(Site::PRIMARY);
            $table
                ->timestamps();
        });
    }

    /**
     * @return void
     */
    private function createCacheLocksTable(): void
    {
        Schema::create(CacheLock::TABLE, function (Blueprint $table)
        {
            $table
                ->string(CacheLock::KEY)
                ->primary();
            $table
                ->string(CacheLock::OWNER);
            $table
                ->integer(CacheLock::EXPIRATION);
        });
    }

    #endregion
};
