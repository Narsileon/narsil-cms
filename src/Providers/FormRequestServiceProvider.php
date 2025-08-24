<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Support\ServiceProvider;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class FormRequestServiceProvider extends ServiceProvider
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
     * Register the form requests from the config file as singletons.
     *
     * @return void
     */
    protected function registerFormRequests(): void
    {
        $config = config('narsil.form-requests', []);

        foreach ($config as $abstract => $concrete)
        {
            $this->app->singleton($abstract, $concrete);
        }
    }

    #endregion
}
