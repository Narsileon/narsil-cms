<?php

namespace Narsil\Cms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Narsil\Cms\Providers\CommandServiceProvider;
use Narsil\Cms\Providers\ConfigurationServiceProvider;
use Narsil\Cms\Providers\FieldServiceProvider;
use Narsil\Cms\Providers\FormRequestServiceProvider;
use Narsil\Cms\Providers\FormServiceProvider;
use Narsil\Cms\Providers\FortifyServiceProvider;
use Narsil\Cms\Providers\HorizonServiceProvider;
use Narsil\Cms\Providers\LocalizationServiceProvider;
use Narsil\Cms\Providers\MenuServiceProvider;
use Narsil\Cms\Providers\MiddlewareServiceProvider;
use Narsil\Cms\Providers\MigrationServiceProvider;
use Narsil\Cms\Providers\ObserverServiceProvider;
use Narsil\Cms\Providers\PolicyServiceProvider;
use Narsil\Cms\Providers\RelationServiceProvider;
use Narsil\Cms\Providers\ResourceServiceProvider;
use Narsil\Cms\Providers\RouteServiceProvider;
use Narsil\Cms\Providers\TableServiceProvider;
use Narsil\Cms\Providers\ViewServiceProvider;
use Nuwave\Lighthouse\LighthouseServiceProvider;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class NarsilServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * Boot any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Model::preventLazyLoading(!App::isProduction());
    }

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $this->registerProviders();
    }

    #endregion

    #region PROTECTED METHODS

    protected function registerProviders(): void
    {
        $this->app->register(CommandServiceProvider::class);
        $this->app->register(ConfigurationServiceProvider::class);
        $this->app->register(FieldServiceProvider::class);
        $this->app->register(FormRequestServiceProvider::class);
        $this->app->register(FormServiceProvider::class);
        $this->app->register(FortifyServiceProvider::class);
        $this->app->register(HorizonServiceProvider::class);
        $this->app->register(LighthouseServiceProvider::class);
        $this->app->register(LocalizationServiceProvider::class);
        $this->app->register(MenuServiceProvider::class);
        $this->app->register(MiddlewareServiceProvider::class);
        $this->app->register(MigrationServiceProvider::class);
        $this->app->register(ObserverServiceProvider::class);
        $this->app->register(PolicyServiceProvider::class);
        $this->app->register(RelationServiceProvider::class);
        $this->app->register(ResourceServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(TableServiceProvider::class);
        $this->app->register(ViewServiceProvider::class);
    }

    #endregion
}
