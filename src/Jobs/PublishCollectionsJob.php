<?php

namespace Narsil\Jobs;

#region USE

use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Narsil\Models\Collections\Template;
use Throwable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class PublishCollectionsJob extends AbstractJob
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function handle(): void
    {
        $templates = Template::all();


        $jobs = $templates->map(function ($template)
        {
            new PublishCollectionJob($template);
        });

        Bus::batch($jobs)
            ->then(function (Batch $batch)
            {
                Log::info('Publishing jobs have been successfully completed.');
            })
            ->catch(function (Throwable $error)
            {
                Log::error("Publishing jobs have failed: " . $error->getMessage());
            })
            ->dispatch();
    }

    #endregion
}
