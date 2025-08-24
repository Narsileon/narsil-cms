<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Support\ServiceProvider;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class ObserverServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function boot(): void
    {
        $this->bootObservers();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Boot the observers from the config file.
     *
     * @return void
     */
    protected function bootObservers(): void
    {
        $config = config('narsil.observers', []);

        foreach ($config as $model => $observer)
        {
            $model::observe($observer);
        }
    }

    #endregion
}
