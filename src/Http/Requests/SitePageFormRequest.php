<?php

namespace Narsil\Http\Requests;

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
        return [
            SitePage::CHANGE_FREQ => [
                FormRule::STRING,
            ],
            SitePage::META_DESCRIPTION => [
                FormRule::ARRAY,
            ],
            SitePage::PARENT_ID => [
                FormRule::INTEGER,
                FormRule::REQUIRED,
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
            SitePage::SITE_ID => [
                FormRule::INTEGER,
                FormRule::REQUIRED,
            ],
            SitePage::TITLE => [
                FormRule::ARRAY,
                FormRule::REQUIRED,
            ],
        ];
    }

    #endregion
}
