<?php

namespace App\Http\Requests\Resources;

#region USE

use App\Interfaces\FormRequests\Resources\ISiteGroupFormRequest;
use App\Models\SiteGroup;
use App\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteGroupFormRequest implements ISiteGroupFormRequest
{
    #region PUBLIC METHODS

    /**
     * {@inheritdoc}
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
