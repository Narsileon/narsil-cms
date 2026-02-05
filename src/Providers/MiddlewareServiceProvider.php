<?php

namespace Narsil\Cms\Providers;

#region USE

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Narsil\Cms\Http\Middleware\InertiaMiddleware;
use Narsil\Cms\Http\Middleware\LocaleMiddleware;
use Narsil\Cms\Http\Middleware\UserConfigurationMiddleware;
use Narsil\Cms\Http\Middleware\WithoutSsr;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class MiddlewareServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * Boot any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->bootNarsilWebMiddleware();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Boot the middleware.
     *
     * @return void
     */
    protected function bootNarsilWebMiddleware(): void
    {
        $router = $this->app->make(Router::class);

        $router->middlewareGroup('narsil-web', [
            WithoutSsr::class,
            UserConfigurationMiddleware::class,
            LocaleMiddleware::class,
            InertiaMiddleware::class,
        ]);
    }

    #endregion
}
