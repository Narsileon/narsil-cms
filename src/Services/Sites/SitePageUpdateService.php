<?php

declare(strict_types=1);

namespace Narsil\Cms\Services\Sites;

#region USE

use Illuminate\Support\Arr;
use Narsil\Cms\Contracts\Actions\Sites\SyncSitePageEntities;
use Narsil\Cms\Models\Sites\SitePage;

#endregion

final class SitePageUpdateService
{
    #region PUBLIC METHODS

    /**
     * @param SitePage $sitePage
     * @param array $attributes
     *
     * @return SitePage
     */
    public function update(SitePage $sitePage, array $attributes): SitePage
    {
        $sitePage->update($attributes);

        app(SyncSitePageEntities::class)
            ->run($sitePage, Arr::get($attributes, SitePage::RELATION_ENTITIES, []));

        return $sitePage->refresh();
    }

    #endregion
}
