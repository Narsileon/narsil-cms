<?php

namespace Narsil\Http\Requests;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\FormRequests\UserConfigurationFormRequest as Contract;
use Narsil\Models\Users\UserConfiguration;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserConfigurationFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(?Model $model = null): array
    {
        return [
            UserConfiguration::COLOR => [
                FormRule::STRING,
                FormRule::min(1),
                FormRule::SOMETIMES,
            ],
            UserConfiguration::LOCALE => [
                FormRule::STRING,
                FormRule::min(1),
                FormRule::SOMETIMES,
            ],
            UserConfiguration::PREFERENCES => [
                FormRule::ARRAY,
                FormRule::SOMETIMES,
            ],
            UserConfiguration::RADIUS => [
                FormRule::NUMERIC,
                FormRule::min(0),
                FormRule::max(2),
                FormRule::SOMETIMES,
            ],
            UserConfiguration::THEME => [
                FormRule::STRING,
                FormRule::min(1),
                FormRule::SOMETIMES,
            ],
        ];
    }

    #endregion
}
