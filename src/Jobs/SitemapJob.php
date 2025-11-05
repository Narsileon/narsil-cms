<?php

namespace Narsil\Jobs;

#region USE

use Narsil\Support\SitemapIndex;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitemapJob extends AbstractJob
{
    #region PUBLIC METHODS

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        new SitemapIndex()
            ->generate();
    }

    #endregion
}
