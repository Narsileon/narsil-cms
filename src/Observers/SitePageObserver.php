<?php

namespace Narsil\Observers;

#region USE

use Narsil\Jobs\SitemapJob;
use Narsil\Models\Sites\SitePage;
use Narsil\Models\Sites\SitePageRelation;

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
     * @param SitePage $sitePage
     *
     * @return void
     */
    public function saved(SitePage $sitePage): void
    {
        $this->syncRelations($sitePage);
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

    /**
     * @param SitePage $sitePage
     *
     * @return void
     */
    protected function syncRelations(SitePage $sitePage): void
    {
        $translations = $sitePage->getTranslations(SitePage::ENTITY);

        foreach ($translations as $relations)
        {
            foreach ($relations as $relation)
            {
                [$table, $id] = explode('-', $relation, 2);

                SitePageRelation::firstOrCreate([
                    SitePageRelation::PAGE_ID => $sitePage->{SitePage::ID},
                    SitePageRelation::TARGET_ID => $id,
                    SitePageRelation::TARGET_TABLE => $table,
                ]);
            }
        }
    }

    #endregion
}
