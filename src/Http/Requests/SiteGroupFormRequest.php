<?php

namespace Narsil\Http\Requests;

#region USE

use Narsil\Contracts\FormRequests\SiteGroupFormRequest as Contract;
use Narsil\Models\Sites\SiteGroup;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteGroupFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            SiteGroup::NAME => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],
        ];
    }

    #endregion
}
