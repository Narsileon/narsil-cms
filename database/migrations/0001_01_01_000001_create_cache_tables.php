<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Narsil\Models\Caches\Cache;
use Narsil\Models\Caches\CacheLock;

#endregion

return new class extends Migration
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
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
     * {@inheritDoc}
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
        Schema::create(Cache::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->string(Cache::KEY)
                ->primary();
            $blueprint
                ->mediumText(Cache::VALUE);
            $blueprint
                ->integer(Cache::EXPIRATION);
        });
    }

    /**
     * @return void
     */
    private function createCacheLocksTable(): void
    {
        Schema::create(CacheLock::TABLE, function (Blueprint $blueprint)
        {
            $blueprint
                ->string(CacheLock::KEY)
                ->primary();
            $blueprint
                ->string(CacheLock::OWNER);
            $blueprint
                ->integer(CacheLock::EXPIRATION);
        });
    }

    #endregion
};
