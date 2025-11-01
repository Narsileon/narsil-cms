<?php

namespace Narsil\Http\Requests;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\FormRequests\HostPageFormRequest as Contract;
use Narsil\Models\Hosts\HostPage;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostPageFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(?Model $model = null): array
    {
        return [
            HostPage::CHANGE_FREQ => [
                FormRule::STRING,
            ],
            HostPage::HOST_ID => [
                FormRule::INTEGER,
                FormRule::REQUIRED,
            ],
            HostPage::META_DESCRIPTION => [
                FormRule::ARRAY,
            ],
            HostPage::PARENT_ID => [
                FormRule::INTEGER,
                FormRule::REQUIRED,
            ],
            HostPage::PRIORITY => [
                FormRule::NUMERIC,
            ],
            HostPage::OPEN_GRAPH_DESCRIPTION => [
                FormRule::ARRAY,
            ],
            HostPage::OPEN_GRAPH_TITLE => [
                FormRule::ARRAY,
            ],
            HostPage::OPEN_GRAPH_TYPE => [
                FormRule::STRING,
            ],
            HostPage::ROBOTS => [
                FormRule::STRING,
            ],
            HostPage::TITLE => [
                FormRule::ARRAY,
                FormRule::REQUIRED,
            ],
        ];
    }

    #endregion
}
