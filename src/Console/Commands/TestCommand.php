<?php

namespace Narsil\Cms\Console\Commands;

#region USE

use Illuminate\Console\Command;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TestCommand extends Command
{
    #region PROPERTIES

    /**
     * {@inheritDoc}
     */
    protected $description = 'A quick and simple test.';

    /**
     * {@inheritDoc}
     */
    protected $signature = 'narsil:test';

    #endregion

    #region PUBLIC METHODS

    /**
     * @return void
     */
    public function handle(): void
    {
        //
    }

    #endregion
}
