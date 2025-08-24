<?php

namespace Narsil\Http\Requests;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\FormRequests\SiteFormRequest as Contract;
use Narsil\Models\Sites\Site;
use Narsil\Validation\FormRule;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class SiteFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(?Model $model = null): array
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
