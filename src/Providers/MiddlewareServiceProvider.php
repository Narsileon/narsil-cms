<?php

declare(strict_types=1);

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

#endregion

final class MiddlewareServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * @return void
     */
    public function boot(): void
    {
        $this->bootNarsilWebMiddleware();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return void
     */
    protected function bootNarsilWebMiddleware(): void
    {
        $router = $this->app->make(Router::class);

        $router->middlewareGroup('web', [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            ShareErrorsFromSession::class,
            ValidateCsrfToken::class,
            SubstituteBindings::class,
        ]);

        $router->middlewareGroup('narsil', [
            UserConfigurationMiddleware::class,
            LocaleMiddleware::class,
        ]);
    }

    #endregion
}
