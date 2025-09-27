<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Narsil\Http\Middleware\Inertia\HandleInertiaRequests;
use Narsil\Http\Middleware\LocaleMiddleware;
use Narsil\Http\Middleware\UserConfigurationMiddleware;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class RouteServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function boot(): void
    {
        $this->bootMiddlewares();
        $this->bootRoutes();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return void
     */
    protected function bootMiddlewares(): void
    {
        $router = $this->app->make(Router::class);

        $router->middlewareGroup('narsil.web', [
            LocaleMiddleware::class,
            UserConfigurationMiddleware::class,
            HandleInertiaRequests::class,
        ]);
    }

    /**
     * @return void
     */
    protected function bootRoutes(): void
    {
        Route::middleware([
            'web',
            'narsil.web',
        ])
            ->prefix('narsil')
            ->group(__DIR__ . '/../../routes/web.php');

        Route::middleware('api')
            ->prefix('api')
            ->group(__DIR__ . '/../../routes/api.php');

        Route::middleware([
            'web',
            'narsil.web',
        ])
            ->prefix('narsil')
            ->group(__DIR__ . '/../../routes/graphql.php');
    }

    #endregion
}
