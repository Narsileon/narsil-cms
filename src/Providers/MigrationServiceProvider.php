<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Narsil\Models\Globals\Footer;
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
        Event::listen(MigrationsEnded::class, function (MigrationsEnded $event)
        {
            Artisan::call('narsil:sync-permissions');

            if (!Site::exists())
            {
                $this->createFirstWebsite();
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

    #region PRIVATE METHODS

    private function createFirstWebsite(): void
    {
        $baseUrl = parse_url(Config::get('app.url'), PHP_URL_HOST);

        $footer = Footer::factory()->create();

        Site::factory()->create([
            Site::FOOTER_ID => $footer->{Footer::ID},
            Site::HANDLE => $baseUrl,
            Site::NAME => $baseUrl,
        ]);
    }

    #endregion
}
