<?php

namespace Narsil;

#region USE

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Narsil\Providers\CommandServiceProvider;
use Narsil\Providers\ComponentServiceProvider;
use Narsil\Providers\FieldServiceProvider;
use Narsil\Providers\FormRequestServiceProvider;
use Narsil\Providers\FormServiceProvider;
use Narsil\Providers\FortifyServiceProvider;
use Narsil\Providers\ObserverServiceProvider;
use Narsil\Providers\PolicyServiceProvider;
use Narsil\Providers\TableServiceProvider;
use Narsil\Providers\TranslationServiceProvider;

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
    }

    /**
     * {@inheritDoc}
     */
    public function boot(): void
    {
        $this->bootMigrations();
        $this->bootPublishes();
        $this->bootRoutes();
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
        ], 'narsil-cms-configs');

        $this->publishes([
            __DIR__ . '/../lang' => lang_path('vendor/narsil-cms'),
        ], 'narsil-cms-translations');
    }

    /**
     * @return void
     */
    protected function bootRoutes(): void
    {
        Route::middleware('web')
            ->prefix('narsil')
            ->group(__DIR__ . '/../routes/web.php');

        Route::middleware('web')
            ->prefix('narsil')
            ->group(__DIR__ . '/../routes/graphql.php');
    }

    protected function registerConfigs(): void
    {
        $configs = [
            'narsil.components' => __DIR__ . '/../config/narsil/components.php',
            'narsil.fields' => __DIR__ . '/../config/narsil/fields.php',
            'narsil.form-requests' => __DIR__ . '/../config/narsil/form-requests.php',
            'narsil.forms'  => __DIR__ . '/../config/narsil/forms.php',
            'narsil.observers' => __DIR__ . '/../config/narsil/observers.php',
            'narsil.policies' => __DIR__ . '/../config/narsil/policies.php',
            'narsil.tables' => __DIR__ . '/../config/narsil/tables.php',
        ];

        foreach ($configs as $key => $path)
        {
            $this->mergeConfigFrom($path, $key);
        }
    }

    protected function registerProviders(): void
    {
        $this->app->register(CommandServiceProvider::class);
        $this->app->register(ComponentServiceProvider::class);
        $this->app->register(FieldServiceProvider::class);
        $this->app->register(FormRequestServiceProvider::class);
        $this->app->register(FormServiceProvider::class);
        $this->app->register(FortifyServiceProvider::class);
        $this->app->register(ObserverServiceProvider::class);
        $this->app->register(PolicyServiceProvider::class);
        $this->app->register(TableServiceProvider::class);
        $this->app->register(TranslationServiceProvider::class);
    }

    #endregion
}
