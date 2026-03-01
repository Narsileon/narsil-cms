<?php

namespace Narsil\Cms\Providers;

#region USE

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class NarsilServiceProvider extends ServiceProvider
{
    #region PROTECTED METHODS

    /**
     * Boot the API routes.
     *
     * @param string $path
     *
     * @return void
     */
    protected function bootApiRoutes(string $path): void
    {
        Route::middleware([
            'api',
            'auth:sanctum',
        ])
            ->prefix('api')
            ->as('api.')
            ->group($path);
    }

    /**
     * Boot the CMS routes.
     *
     * @param string $path
     *
     * @return void
     */
    protected function bootCmsRoutes(string $path): void
    {
        Route::middleware([
            'web',
            'narsil-cms',
        ])
            ->prefix('admin')
            ->group($path);
    }

    /**
     * Boot the web routes.
     *
     * @param string $path
     *
     * @return void
     */
    protected function bootWebRoutes(string $path): void
    {
        Route::middleware([
            'web',
        ])
            ->group($path);
    }

    #endregion
}
