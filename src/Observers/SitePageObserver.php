<?php

namespace Narsil\Observers;

#region USE

use Narsil\Jobs\SitemapJob;
use Narsil\Models\Sites\SitePage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitePageObserver
{
    #region PUBLIC METHODS

    /**
     * @param SitePage $host
     *
     * @return void
     */
    public function created(SitePage $sitePage): void
    {
        SitemapJob::dispatch();
    }

    /**
     * @param SitePage $host
     *
     * @return void
     */
    public function updated(SitePage $sitePage): void
    {
        if ($sitePage->wasChanged(SitePage::SLUG))
        {
            SitemapJob::dispatch();
        }
    }

    #endregion
}
