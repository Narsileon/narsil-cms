<?php

namespace App\Http\Requests\Sites;

#region USE

use App\Http\Requests\AbstractFormRequest;
use App\Models\SiteGroup;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteGroupRequest extends AbstractFormRequest
{
    #region PUBLIC METHODS

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            SiteGroup::NAME => [
                self::STRING,
                self::REQUIRED,
            ],
        ];
    }

    #endregion
}
