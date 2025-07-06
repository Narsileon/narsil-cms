<?php

namespace App\Http\Requests\Users;

#region USE

use App\Http\Requests\AbstractFormRequest;
use App\Models\Users\UserConfiguration;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserConfigurationUpdateRequest extends AbstractFormRequest
{
    #region PUBLIC METHODS

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            UserConfiguration::COLOR => [
                self::STRING,
                self::min(1),
                self::SOMETIMES,
            ],
            UserConfiguration::LOCALE => [
                self::STRING,
                self::min(1),
                self::SOMETIMES,
            ],
            UserConfiguration::PREFERENCES => [
                self::ARRAY,
                self::SOMETIMES,
            ],
            UserConfiguration::RADIUS => [
                self::NUMERIC,
                self::min(0),
                self::max(2),
                self::SOMETIMES,
            ],
            UserConfiguration::THEME => [
                self::STRING,
                self::min(1),
                self::SOMETIMES,
            ],
        ];
    }

    #endregion
}
