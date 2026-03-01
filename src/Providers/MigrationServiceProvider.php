<?php

namespace Narsil\Cms\Providers;

#region USE

use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Narsil\Base\Models\Policies\Permission;
use Narsil\Cms\Database\Seeders\ValidationRuleSeeder;
use Narsil\Cms\Models\ValidationRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
final class MigrationServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * Boot any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->bootEvent();
        $this->bootMigrations();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Boot the events.
     *
     * @return void
     */
    protected function bootEvent(): void
    {
        Event::listen(MigrationsEnded::class, function ()
        {
            Cache::flush();

            if (Schema::hasTable(Permission::TABLE))
            {
                $this->syncPermissions();
            }
            if (Schema::hasTable(ValidationRule::TABLE))
            {
                new ValidationRuleSeeder()->run();
            }
        });
    }

    /**
     * Boot the migrations.
     *
     * @return void
     */
    protected function bootMigrations(): void
    {
        $this->loadMigrationsFrom([
            __DIR__ . '/../../database/migrations',
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return void
     */
    protected function syncPermissions(): void
    {
        Artisan::call('narsil:sync-permissions');
    }

    #endregion
}
