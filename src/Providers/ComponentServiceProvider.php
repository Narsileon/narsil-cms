<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Support\ServiceProvider;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ComponentServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $implementations = config('narsil.components', []);

        foreach ($implementations as $abstract => $concrete)
        {
            $this->app->singleton($abstract, $concrete);
            $this->app->tag($abstract, ['components']);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function boot(): void
    {
        //
    }

    #endregion
}
