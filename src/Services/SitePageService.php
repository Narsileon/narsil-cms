<?php

namespace Narsil\Cms\Services;

#region USE

use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Models\Sites\SitePageEntity;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class SitePageService
{
    #region PUBLIC METHODS

    /**
     * @param SitePage $sitePage
     * @param array $entities
     *
     * @return void
     */
    public static function syncEntities(SitePage $sitePage, array $entities): void
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
    }

    #endregion
}
