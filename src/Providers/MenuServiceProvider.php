<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Support\ServiceProvider;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class MenuServiceProvider extends ServiceProvider
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
        $config = config('narsil.menus', []);

        foreach ($config as $abstract => $concrete)
        {
            $this->app->singleton($abstract, $concrete);
        }
    }

    #endregion
}
