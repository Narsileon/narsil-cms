<?php

namespace Narsil\Jobs;

#region USE

use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AbstractJob implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    #region PUBLIC METHODS

    /**
     * Execute the job.
     *
     * @return void
     */
    abstract public function handle(): void;

    #endregion
}
