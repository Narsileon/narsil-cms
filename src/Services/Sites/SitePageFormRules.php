<?php

declare(strict_types=1);

namespace Narsil\Cms\Services\Sites;

#region USE

use Narsil\Base\Validation\FormRule;
use Narsil\Cms\Enums\SitePageAdapterEnum;
use Narsil\Cms\Models\Sites\SitePage;

#endregion

final class SitePageFormRules
{
    #region PUBLIC METHODS

    /**
     * @param SitePage|null $sitePage
     *
     * @return array
     */
    public function forPage(?SitePage $sitePage = null): array
    {
        $rules = [
            SitePage::ADAPTER => [
                FormRule::enum(SitePageAdapterEnum::class),
            ],
            SitePage::CHANGE_FREQ => [
                FormRule::STRING,
            ],
            SitePage::COLLECTION => [
                FormRule::STRING,
                FormRule::NULLABLE,
            ],
            SitePage::META_DESCRIPTION => [
                FormRule::LIST,
            ],
            SitePage::PARENT_ID => [
                FormRule::INTEGER,
                FormRule::NULLABLE,
            ],
            SitePage::PRIORITY => [
                FormRule::NUMERIC,
            ],
            SitePage::OPEN_GRAPH_DESCRIPTION => [
                FormRule::LIST,
            ],
            SitePage::OPEN_GRAPH_TITLE => [
                FormRule::LIST,
            ],
            SitePage::OPEN_GRAPH_TYPE => [
                FormRule::STRING,
            ],
            SitePage::ROBOTS => [
                FormRule::STRING,
            ],
            SitePage::SHOW_IN_MENU => [
                FormRule::BOOLEAN,
                FormRule::REQUIRED,
            ],
            SitePage::SITE_ID => [
                FormRule::INTEGER,
                FormRule::REQUIRED,
            ],
            SitePage::SLUG => [
                FormRule::LIST,
                FormRule::REQUIRED,
            ],
            SitePage::SLUG . '.*' => [
                FormRule::ALPHA_DASH,
                FormRule::LOWERCASE,
                FormRule::doesntStartWith('-'),
                FormRule::doesntEndWith('-'),
            ],
            SitePage::TITLE => [
                FormRule::LIST,
                FormRule::REQUIRED,
            ],
            SitePage::RELATION_ENTITIES => [
                FormRule::LIST,
                FormRule::NULLABLE,
            ],
        ];

        if ($sitePage)
        {
            unset($rules[SitePage::PARENT_ID]);
        }

        return $rules;
    }

    #endregion
}
