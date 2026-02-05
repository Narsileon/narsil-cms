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
class FormServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $this->registerForms();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Register the configured forms as bindings.
     *
     * @return void
     */
    protected function registerForms(): void
    {
        $config = Config::get('narsil.bindings.forms', []);

        foreach ($config as $abstract => $concrete)
        {
            $this->app->bind($abstract, $concrete);
        }
    }

    #endregion
}
