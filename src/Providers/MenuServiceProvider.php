<?php

declare(strict_types=1);

namespace Narsil\Cms\Providers;

#region USE

use Illuminate\Support\ServiceProvider;
use Narsil\Base\Narsil;

#endregion

final class MenuServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $this->registerMenus();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Register the configured menus as singletons.
     *
     * @return void
     */
    protected function registerMenus(): void
    {
        $menus = app(Narsil::class)->menus();

        foreach ($menus as $abstract => $concrete)
        {
            $this->app->singleton($abstract, $concrete);
        }
    }

    #endregion
}
