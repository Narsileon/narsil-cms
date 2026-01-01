<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Narsil\Database\Seeders\Templates\ContentSeeder;
use Narsil\Database\Seeders\ValidationRuleSeeder;
use Narsil\Models\Sites\Site;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class MigrationServiceProvider extends ServiceProvider
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
            $this->syncPermissions();

            if (!Site::exists())
            {
                $this->createSite();

                new ContentSeeder()->run();
            }

            new ValidationRuleSeeder()->run();
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
    protected function createSite(): void
    {
        $baseUrl = parse_url(Config::get('app.url'), PHP_URL_HOST);

        Site::factory()->create([
            Site::HANDLE => $baseUrl,
            Site::NAME => $baseUrl,
        ]);
    }

    /**
     * @return void
     */
    protected function syncPermissions(): void
    {
        Artisan::call('narsil:sync-permissions');
    }

    #endregion
}
