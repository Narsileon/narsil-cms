<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Narsil\Http\Middleware\Inertia\HandleInertiaRequests;
use Narsil\Http\Middleware\LocaleMiddleware;
use Narsil\Http\Middleware\UserConfigurationMiddleware;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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
            UserConfigurationMiddleware::class,
            LocaleMiddleware::class,
            HandleInertiaRequests::class,
        ]);
    }

    #endregion
}
