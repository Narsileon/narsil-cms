<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Support\ServiceProvider;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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
     * Register the configured fields as bindings.
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
