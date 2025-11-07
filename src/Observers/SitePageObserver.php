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
     * @param SitePage $sitePage
     *
     * @return void
     */
    public function created(SitePage $sitePage): void
    {
        $this->dispatchSitemapJob($sitePage);
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
            $this->dispatchSitemapJob($sitePage);
        }
    }

    #endregion

    #region PROTECTED METHODS

    protected function dispatchSitemapJob(SitePage $sitePage): void
    {
        $sitePage->loadMissing([
            SitePage::RELATION_SITE,
        ]);

        SitemapJob::dispatch($sitePage->{SitePage::RELATION_SITE});
    }

    #endregion
}
