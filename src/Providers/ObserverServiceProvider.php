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
class ObserverServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * Boot any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->bootObservers();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Boot the configured observers.
     *
     * @return void
     */
    protected function bootObservers(): void
    {
        $config = Config::get('narsil.models.observers', []);

        foreach ($config as $model => $observer)
        {
            $model::observe($observer);
        }
    }

    #endregion
}
