<?php

namespace Narsil\Cms\Providers;

#region USE

use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Router;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Narsil\Base\Http\Middleware\LocaleMiddleware;
use Narsil\Base\Http\Middleware\UserConfigurationMiddleware;
use Narsil\Base\Http\Middleware\WithoutSsrMiddleware;
use Narsil\Cms\Http\Middleware\InertiaMiddleware;
use Narsil\Cms\Http\Middleware\SchemaMiddleware;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
final class MiddlewareServiceProvider extends ServiceProvider
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

        $router->middlewareGroup('web', [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            SchemaMiddleware::class,
            ShareErrorsFromSession::class,
            ValidateCsrfToken::class,
            SubstituteBindings::class,
        ]);

        $router->middlewareGroup('narsil-cms', [
            WithoutSsrMiddleware::class,
            UserConfigurationMiddleware::class,
            LocaleMiddleware::class,
            InertiaMiddleware::class,
        ]);
    }

    #endregion
}
