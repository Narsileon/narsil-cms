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
class ResourceServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $this->registerResources();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Register the configured resources as binding.
     *
     * @return void
     */
    protected function registerResources(): void
    {
        $config = Config::get('narsil.bindings.resources', []);

        foreach ($config as $abstract => $concrete)
        {
            $this->app->bind($abstract, $concrete);
        }
    }

    #endregion
}
