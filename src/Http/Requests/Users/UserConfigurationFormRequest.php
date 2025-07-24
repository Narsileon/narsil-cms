<?php

namespace Narsil\Http\Requests\Users;

#region USE

use Narsil\Contracts\FormRequests\Users\UserConfigurationFormRequest as Contract;
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
    public function rules(): array
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
