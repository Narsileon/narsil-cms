<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class RouteServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * Boot any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->bootApiRoutes();
        $this->bootCpRoutes();
        $this->bootGraphQLRoutes();
        $this->bootWebRoutes();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Boot the API routes.
     *
     * @return void
     */
    protected function bootApiRoutes(): void
    {

        Route::middleware('api')
            ->prefix('api')
            ->group(__DIR__ . '/../../routes/api.php');
    }

    /**
     * Boot the control panel routes.
     *
     * @return void
     */
    protected function bootCpRoutes(): void
    {
        Route::middleware([
            'web',
            'narsil-web',
        ])
            ->prefix('narsil')
            ->group(__DIR__ . '/../../routes/cp.php');
    }


    /**
     * Boot the GraphQL routes.
     *
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
     * Boot the web routes.
     *
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
