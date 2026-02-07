<?php

namespace Narsil\Cms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Narsil\Cms\Providers\CommandServiceProvider;
use Narsil\Cms\Providers\FieldServiceProvider;
use Narsil\Cms\Providers\FormRequestServiceProvider;
use Narsil\Cms\Providers\FormServiceProvider;
use Narsil\Cms\Providers\FortifyServiceProvider;
use Narsil\Cms\Providers\HorizonServiceProvider;
use Narsil\Cms\Providers\MenuServiceProvider;
use Narsil\Cms\Providers\MiddlewareServiceProvider;
use Narsil\Cms\Providers\MigrationServiceProvider;
use Narsil\Cms\Providers\MorphServiceProvider;
use Narsil\Cms\Providers\NarsilServiceProvider;
use Narsil\Cms\Providers\ObserverServiceProvider;
use Narsil\Cms\Providers\PluginServiceProvider;
use Narsil\Cms\Providers\PolicyServiceProvider;
use Narsil\Cms\Providers\ResourceServiceProvider;
use Narsil\Cms\Providers\TableServiceProvider;
use Narsil\Cms\Providers\TranslationServiceProvider;
use Narsil\Cms\Providers\ViewServiceProvider;
use Nuwave\Lighthouse\LighthouseServiceProvider;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ServiceProvider extends NarsilServiceProvider
{
    #region PUBLIC METHODS

    /**
     * Boot any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'narsil-cms');

        $this->bootApiRoutes(__DIR__ . '/../routes/api.php');
        $this->bootCmsRoutes(__DIR__ . '/../routes/cms.php');
        $this->bootWebRoutes(__DIR__ . '/../routes/web.php');

        $this->bootGraphQLRoutes();
        $this->bootPublishes();

        Model::preventLazyLoading(!App::isProduction());
    }

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $this->mergeConfiguration(__DIR__ . '/../config');

        $this->registerProviders();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Boot the GraphQL routes.
     *
     * @return void
     */
    protected function bootGraphQLRoutes(): void
    {
        Route::middleware([
            'web',
            'auth',
            'verified',
            'narsil-cms',
        ])
            ->prefix('narsil')
            ->group(__DIR__ . '/../routes/graphql.php');
    }

    /**
     * Boot the publishes.
     *
     * @return void
     */
    protected function bootPublishes(): void
    {
        $this->publishes([
            '/../config' => config_path(),
        ], 'narsil-cms-config');

        $this->publishes([
            __DIR__ . '/../lang' => lang_path('vendor/narsil-cms'),
        ], 'narsil-cms-lang');
    }

    protected function registerProviders(): void
    {
        $this->app->register(PluginServiceProvider::class);
        $this->app->register(CommandServiceProvider::class);
        $this->app->register(FieldServiceProvider::class);
        $this->app->register(FormRequestServiceProvider::class);
        $this->app->register(FormServiceProvider::class);
        $this->app->register(FortifyServiceProvider::class);
        $this->app->register(HorizonServiceProvider::class);
        $this->app->register(LighthouseServiceProvider::class);
        $this->app->register(MenuServiceProvider::class);
        $this->app->register(MiddlewareServiceProvider::class);
        $this->app->register(MigrationServiceProvider::class);
        $this->app->register(ResourceServiceProvider::class);
        $this->app->register(ObserverServiceProvider::class);
        $this->app->register(PolicyServiceProvider::class);
        $this->app->register(MorphServiceProvider::class);
        $this->app->register(TableServiceProvider::class);
        $this->app->register(TranslationServiceProvider::class);
        $this->app->register(ViewServiceProvider::class);
    }

    #endregion
}
