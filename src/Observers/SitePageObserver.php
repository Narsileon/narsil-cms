<?php

namespace Narsil\Cms\Observers;

#region USE

use Narsil\Cms\Jobs\SitemapJob;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Models\Sites\SitePageEntity;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitePageObserver
{
    #region PUBLIC METHODS

    /**
     * @param SitePage $model
     *
     * @return void
     */
    public function created(SitePage $model): void
    {
        $this->dispatchSitemapJob($model);
    }

    /**
     * @param SitePage $model
     *
     * @return void
     */
    public function saved(SitePage $model): void
    {
        $this->syncRelations($model);
    }

    /**
     * @param SitePage $model
     *
     * @return void
     */
    public function updated(SitePage $model): void
    {
        if ($model->wasChanged(SitePage::SLUG))
        {
            $this->dispatchSitemapJob($model);
        }
    }

    #endregion

    #region PROTECTED METHODS

    protected function dispatchSitemapJob(SitePage $model): void
    {
        $model->loadMissing([
            SitePage::RELATION_SITE,
        ]);

        SitemapJob::dispatch($model->{SitePage::RELATION_SITE});
    }

    /**
     * @param SitePage $model
     *
     * @return void
     */
    protected function syncRelations(SitePage $model): void
    {
        $translations = $model->getTranslations(SitePage::ENTITY);

        foreach ($translations as $relations)
        {
            foreach ($relations as $relation)
            {
                [$table, $id] = explode('-', $relation, 2);

                SitePageEntity::firstOrCreate([
                    SitePageEntity::SITE_PAGE_ID => $model->{SitePage::ID},
                    SitePageEntity::TARGET_ID => $id,
                    SitePageEntity::TARGET_TYPE => $table,
                ]);
            }
        }
    }

    #endregion
}
