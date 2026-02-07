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
final class PluginServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $this->registerPlugins();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Register the configured plugins.
     *
     * @return void
     */
    protected function registerPlugins(): void
    {
        $config = Config::get('narsil.plugins', []);

        foreach ($config as $provider)
        {
            $this->app->register($provider);
        }
    }

    #endregion
}
