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
        $this->bootNarsilMiddleware();

        $this->bootApiRoutes();
        $this->bootGraphQLRoutes();
        $this->bootNarsilRoutes();
        $this->bootWebRoutes();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return void
     */
    protected function bootApiRoutes(): void
    {

        Route::middleware('api')
            ->prefix('api')
            ->group(__DIR__ . '/../../routes/api.php');
    }

    /**
     * @return void
     */
    protected function bootGraphQLRoutes(): void
    {

        Route::middleware([
            'web',
            'narsil-web',
        ])
            ->prefix('narsil')
            ->group(__DIR__ . '/../../routes/graphql.php');
    }

    /**
     * @return void
     */
    protected function bootNarsilMiddleware(): void
    {
        $router = $this->app->make(Router::class);

        $router->middlewareGroup('narsil-web', [
            LocaleMiddleware::class,
            UserConfigurationMiddleware::class,
            HandleInertiaRequests::class,
        ]);
    }

    /**
     * @return void
     */
    protected function bootNarsilRoutes(): void
    {
        Route::middleware([
            'web',
            'narsil-web',
        ])
            ->prefix('narsil')
            ->group(__DIR__ . '/../../routes/narsil.php');
    }

    /**
     * @return void
     */
    protected function bootWebRoutes(): void
    {
        Route::middleware([
            'web',
        ])
            ->group(__DIR__ . '/../../routes/web.php');
    }

    #endregion
}
