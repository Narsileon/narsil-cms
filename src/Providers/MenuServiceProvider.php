<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
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
        $config = Config::get('narsil.bindings.menus', []);

        foreach ($config as $abstract => $concrete)
        {
            $this->app->singleton($abstract, $concrete);
        }
    }

    #endregion
}
