<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Hooks\Hosts;

#region USE

use Narsil\Base\Contracts\ModelHook;
use Narsil\Base\Http\Data\ModelHookContext;
use Narsil\Cms\Jobs\SitemapJob;
use Narsil\Cms\Models\Hosts\Host;

#endregion

final class DispatchHostSitemapHook implements ModelHook
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function handle(ModelHookContext $context): void
    {
        if ($context->model instanceof Host)
        {
            SitemapJob::dispatch($context->model);
        }
    }

    #endregion
}
