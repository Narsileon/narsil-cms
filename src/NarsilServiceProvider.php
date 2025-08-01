<?php

namespace Narsil;

#region USE

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Narsil\Providers\ComponentServiceProvider;
use Narsil\Providers\FieldServiceProvider;
use Narsil\Providers\FormRequestServiceProvider;
use Narsil\Providers\FormServiceProvider;
use Narsil\Providers\FortifyServiceProvider;
use Narsil\Providers\TableServiceProvider;
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
        $this->registerConfigs();
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

    #region PROTECTED METHODS

    /**
     * @return void
     */
    protected function bootMigrations(): void
    {
        $this->loadMigrationsFrom([
            __DIR__ . '/../database/migrations',
        ]);
    }

    /**
     * @return void
     */
    protected function bootPublishes(): void
    {
        $this->publishes([
            __DIR__ . '/../config' => config_path(),
        ], 'narsil-cms');
    }

    /**
     * @return void
     */
    protected function bootRoutes(): void
    {
        Route::middleware('web')
            ->prefix('narsil')
            ->group(__DIR__ . '/../routes/web.php');
    }

    /**
     * @return void
     */
    protected function bootTranslations(): void
    {
        $this->loadJsonTranslationsFrom(__DIR__ . '/../lang', 'narsil-cms');
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'narsil-cms');
    }

    protected function registerConfigs(): void
    {
        $configs = [
            'narsil.components' => __DIR__ . '/../config/narsil/components.php',
            'narsil.fields' => __DIR__ . '/../config/narsil/fields.php',
            'narsil.form-requests' => __DIR__ . '/../config/narsil/form-requests.php',
            'narsil.forms'  => __DIR__ . '/../config/narsil/forms.php',
            'narsil.tables' => __DIR__ . '/../config/narsil/tables.php',
        ];

        foreach ($configs as $key => $path)
        {
            $this->mergeConfigFrom($path, $key);
        }
    }

    protected function registerProviders(): void
    {
        $this->app->register(ComponentServiceProvider::class);
        $this->app->register(FieldServiceProvider::class);
        $this->app->register(FormRequestServiceProvider::class);
        $this->app->register(FormServiceProvider::class);
        $this->app->register(FortifyServiceProvider::class);
        $this->app->register(TableServiceProvider::class);
    }

    #endregion
}
