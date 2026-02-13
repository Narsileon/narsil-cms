<?php

namespace Narsil\Cms\Jobs;

#region USE

use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Narsil\Base\Models\Jobs\Job;
use Narsil\Cms\Models\Collections\Template;
use Throwable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class PublishCollectionsJob extends Job
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function handle(): void
    {
        $templates = Template::query()
            ->without([
                Template::RELATION_TABS,
            ])
            ->get();

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
