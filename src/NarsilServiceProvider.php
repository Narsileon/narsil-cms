<?php

namespace Narsil;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Narsil\Providers\CommandServiceProvider;
use Narsil\Providers\ConfigurationServiceProvider;
use Narsil\Providers\FieldServiceProvider;
use Narsil\Providers\FormRequestServiceProvider;
use Narsil\Providers\FormServiceProvider;
use Narsil\Providers\FortifyServiceProvider;
use Narsil\Providers\HorizonServiceProvider;
use Narsil\Providers\LocalizationServiceProvider;
use Narsil\Providers\MenuServiceProvider;
use Narsil\Providers\MiddlewareServiceProvider;
use Narsil\Providers\MigrationServiceProvider;
use Narsil\Providers\ObserverServiceProvider;
use Narsil\Providers\PolicyServiceProvider;
use Narsil\Providers\ResourceServiceProvider;
use Narsil\Providers\RouteServiceProvider;
use Narsil\Providers\TableServiceProvider;
use Narsil\Providers\ViewServiceProvider;
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
        $this->app->register(ResourceServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(TableServiceProvider::class);
        $this->app->register(ViewServiceProvider::class);
    }

    #endregion
}
