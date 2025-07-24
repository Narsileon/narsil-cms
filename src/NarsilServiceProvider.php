<?php

namespace Narsil;

#region USE

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Narsil\Providers\ComponentServiceProvider;
use Narsil\Providers\FieldSettingsServiceProvider;
use Narsil\Providers\FormRequestServiceProvider;
use Narsil\Providers\FormServiceProvider;
use Narsil\Providers\FortifyServiceProvider;
use Narsil\Support\LabelsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class NarsilServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $this->registerProviders();

        $this->app->singleton(LabelsBag::class, function ()
        {
            return new LabelsBag();
        });
    }

    /**
     * {@inheritDoc}
     */
    public function boot(): void
    {
        $this->bootMigrations();
        $this->bootPublishes();
        $this->bootRoutes();
        $this->bootTranslations();
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @return void
     */
    private function bootMigrations(): void
    {
        $this->loadMigrationsFrom([
            __DIR__ . '/../database/migrations',
        ]);
    }

    /**
     * @return void
     */
    private function bootPublishes(): void
    {
        $this->publishes([
            __DIR__ . '/../config' => config_path(),
        ], 'narsil-cms');
    }

    /**
     * @return void
     */
    private function bootRoutes(): void
    {
        Route::middleware('web')
            ->prefix('narsil')
            ->group(__DIR__ . '/../routes/web.php');
    }

    /**
     * @return void
     */
    private function bootTranslations(): void
    {
        $this->loadJsonTranslationsFrom(__DIR__ . '/../lang', 'narsil-cms');
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'narsil-cms');
    }

    private function registerProviders(): void
    {
        $this->app->register(ComponentServiceProvider::class);
        $this->app->register(FieldSettingsServiceProvider::class);
        $this->app->register(FormRequestServiceProvider::class);
        $this->app->register(FormServiceProvider::class);
        $this->app->register(FortifyServiceProvider::class);
    }

    #endregion
}
