<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Support\ServiceProvider;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class TableServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $this->registerTables();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Register the configured tables as singletons.
     *
     * @return void
     */
    protected function registerTables(): void
    {
        $config = config('narsil.tables', []);

        foreach ($config as $table => $template)
        {
            $this->app->singleton("tables.$table", $template);
        }
    }

    #endregion
}
