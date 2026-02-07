<?php

namespace Narsil\Cms\Providers;

#region USE

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
final class FormRequestServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $this->registerFormRequests();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Register the configured form requests as singletons.
     *
     * @return void
     */
    protected function registerFormRequests(): void
    {
        $config = Config::get('narsil.bindings.requests', []);

        foreach ($config as $abstract => $concrete)
        {
            $this->app->singleton($abstract, $concrete);
        }
    }

    #endregion
}
