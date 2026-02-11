<?php

namespace Narsil\Cms\Implementations\Requests;

#region USE

use Narsil\Base\Models\Users\UserConfiguration;
use Narsil\Base\Validation\FormRule;
use Narsil\Cms\Contracts\Requests\UserConfigurationFormRequest as Contract;
use Narsil\Cms\Implementations\AbstractFormRequest;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserConfigurationFormRequest extends AbstractFormRequest implements Contract
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
            UserConfiguration::LANGUAGE => [
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
