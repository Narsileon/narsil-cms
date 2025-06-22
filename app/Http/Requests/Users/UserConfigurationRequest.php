<?php

namespace App\Http\Requests\Users;

#region USE

use App\Http\Requests\AbstractFormRequest;
use App\Models\Users\UserConfiguration;

#endregion

final class UserConfigurationRequest extends AbstractFormRequest
{
    #region PUBLIC METHODS

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            UserConfiguration::LANGUAGE => [
                self::STRING,
                self::min(1),
                self::SOMETIMES,
            ],
            UserConfiguration::PREFERENCES => [
                self::ARRAY,
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
