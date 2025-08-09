<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Support\ServiceProvider;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $this->registerFields();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Register the fields from the config file as bindings.
     *
     * @return void
     */
    protected function registerFields(): void
    {
        $config = config('narsil.fields', []);

        foreach ($config as $abstract => $concrete)
        {
            $this->app->bind($abstract, $concrete);
        }
    }

    #endregion
}
