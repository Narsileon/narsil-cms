<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Support\ServiceProvider;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class BlockServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $this->registerBlocks();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Register the components from the config file as singletons.
     *
     * @return void
     */
    protected function registerBlocks(): void
    {
        $config = config('narsil.blocks', []);

        foreach ($config as $abstract => $concrete)
        {
            $this->app->singleton($abstract, $concrete);
        }
    }

    #endregion
}
