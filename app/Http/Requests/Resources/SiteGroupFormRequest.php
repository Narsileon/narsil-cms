<?php

namespace App\Http\Requests\Resources;

#region USE

use App\Contracts\FormRequests\Resources\SiteGroupFormRequest as Contract;
use App\Models\Sites\SiteGroup;
use App\Validation\FormRule;

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
