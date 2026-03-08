<?php

namespace Narsil\Cms\Implementations\Actions\Sites;

#region USE

use Narsil\Base\Implementations\Action;
use Narsil\Cms\Contracts\Actions\Sites\SyncSitePageEntities as Contract;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Models\Sites\SitePageEntity;

#endregion

/**
 * @author Jonathan Rigaux
 */
class SyncSitePageEntities extends Action implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function run(SitePage $sitePage, array $entities): SitePage
    {
        $uuids = [];

        foreach ($entities as $language => $identifier)
        {
            [$targetType, $targetId] = explode('-', $identifier);

            $sitePageEntity = SitePageEntity::updateOrCreate([
                SitePageEntity::LANGUAGE => $language,
                SitePageEntity::SITE_PAGE_ID => $sitePage->{SitePage::ID},
            ], [
                SitePageEntity::TARGET_ID => $targetId,
                SitePageEntity::TARGET_TYPE => $targetType,
            ]);

            $uuids[] = $sitePageEntity->{SitePageEntity::UUID};
        }

        $sitePage
            ->entities()
            ->whereNotIn(SitePageEntity::UUID, $uuids)
            ->delete();

        return $sitePage;
    }

    #endregion
}
