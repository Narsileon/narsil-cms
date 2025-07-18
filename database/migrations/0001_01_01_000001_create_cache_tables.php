<?php

#region USE

use App\Models\Caches\Cache;
use App\Models\Caches\CacheLock;
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
            $this->createCacheTable();
        }
        if (!Schema::hasTable(CacheLock::TABLE))
        {
            $this->createCacheLocksTable();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(CacheLock::TABLE);
        Schema::dropIfExists(Cache::TABLE);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @return void
     */
    private function createCacheTable(): void
    {
        Schema::create(Cache::TABLE, function (Blueprint $table)
        {
            $table
                ->string(Cache::KEY)
                ->primary();
            $table
                ->mediumText(Cache::VALUE);
            $table
                ->integer(Cache::EXPIRATION);
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
