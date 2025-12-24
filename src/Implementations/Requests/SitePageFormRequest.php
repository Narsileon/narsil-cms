<?php

namespace Narsil\Implementations\Requests;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\FormRequests\SitePageFormRequest as Contract;
use Narsil\Models\Sites\SitePage;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitePageFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(?Model $model = null): array
    {
        $rules = [
            SitePage::CHANGE_FREQ => [
                FormRule::STRING,
            ],
            SitePage::CONTENT => [
                FormRule::ARRAY,
            ],
            SitePage::META_DESCRIPTION => [
                FormRule::ARRAY,
            ],
            SitePage::PARENT_ID => [
                FormRule::INTEGER,
                FormRule::NULLABLE,
            ],
            SitePage::PRIORITY => [
                FormRule::NUMERIC,
            ],
            SitePage::OPEN_GRAPH_DESCRIPTION => [
                FormRule::ARRAY,
            ],
            SitePage::OPEN_GRAPH_TITLE => [
                FormRule::ARRAY,
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
                FormRule::ARRAY,
                FormRule::REQUIRED,
            ],
            SitePage::SLUG . '.*' => [
                FormRule::ALPHA_DASH,
                FormRule::LOWERCASE,
                FormRule::doesntStartWith('-'),
                FormRule::doesntEndWith('-'),
            ],
            SitePage::TITLE => [
                FormRule::ARRAY,
                FormRule::REQUIRED,
            ],
        ];

        if ($model)
        {
            unset($rules[SitePage::PARENT_ID]);
        }

        return $rules;
    }

    #endregion
}
