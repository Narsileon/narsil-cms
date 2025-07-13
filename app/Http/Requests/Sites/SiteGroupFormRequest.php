<?php

namespace App\Http\Requests\Sites;

#region USE

use App\Http\Requests\AbstractFormRequest;
use App\Interfaces\FormRequests\ISiteGroupFormRequest;
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
