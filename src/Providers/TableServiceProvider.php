<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Support\ServiceProvider;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TableServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $config = config('narsil.tables', []);

        foreach ($config as $table => $template)
        {
            $this->app->singleton("tables.$table", $template);
        }
    }

    #endregion
}
