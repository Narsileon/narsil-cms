<?php

namespace Narsil\Http\Requests\Resources;

#region USE

use Narsil\Contracts\FormRequests\Resources\SiteGroupFormRequest as Contract;
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
