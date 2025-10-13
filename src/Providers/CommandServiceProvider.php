<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Support\ServiceProvider;
use Narsil\Console\Commands\GenerateSchema;
use Narsil\Console\Commands\SyncPermissions;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class CommandServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * Boot any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->bootCommands();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Boot the commands.
     *
     * @return void
     */
    protected function bootCommands(): void
    {
        if ($this->app->runningInConsole())
        {
            $this->commands([
                GenerateSchema::class,
                SyncPermissions::class,
            ]);
        }
    }

    #endregion
}
