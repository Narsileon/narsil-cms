<?php

namespace App\Http\Requests\Sites;

#region USE

use App\Interfaces\FormRequests\ISiteFormRequest;
use App\Models\Site;
use App\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteFormRequest implements ISiteFormRequest
{
    #region PUBLIC METHODS

    /**
     * {@inheritdoc}
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
