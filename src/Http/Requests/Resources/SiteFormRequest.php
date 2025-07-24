<?php

namespace Narsil\Http\Requests\Resources;

#region USE

use Narsil\Contracts\FormRequests\Resources\SiteFormRequest as Contract;
use Narsil\Models\Sites\Site;
use Narsil\Validation\FormRule;

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
