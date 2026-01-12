<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Support\ServiceProvider;
use Narsil\Console\Commands\MakeEntityCommand;
use Narsil\Console\Commands\MakeEntityNodeCommand;
use Narsil\Console\Commands\MakeEntityNodeRelationCommand;
use Narsil\Console\Commands\SyncPermissions;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
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
        $this->commands([
            MakeEntityCommand::class,
            MakeEntityNodeCommand::class,
            MakeEntityNodeRelationCommand::class,
            SyncPermissions::class,
        ]);
    }

    #endregion
}
