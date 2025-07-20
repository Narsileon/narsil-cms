<?php

namespace App\Http\Requests\Resources;

#region USE

use App\Contracts\FormRequests\Resources\SiteFormRequest as Contract;
use App\Models\Sites\Site;
use App\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            Site::GROUP_ID => [
                FormRule::INTEGER,
                FormRule::NULLABLE,
            ],
            Site::HANDLE => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],
            Site::LANGUAGE => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],
            Site::NAME => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],
            Site::PRIMARY => [
                FormRule::BOOLEAN,
                FormRule::REQUIRED,
            ],
        ];
    }

    #endregion
}
