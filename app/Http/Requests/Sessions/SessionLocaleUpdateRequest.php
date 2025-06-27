<?php

namespace App\Http\Requests\Sessions;

#region USE

use App\Http\Requests\AbstractFormRequest;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SessionLocaleUpdateRequest extends AbstractFormRequest
{
    #region CONSTANTS

    /**
     * @var string The name of the "locale" parameter.
     */
    public const LOCALE = 'locale';

    #endregion

    #region PUBLIC METHODS

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            self::LOCALE => [
                self::STRING,
                self::min(2),
                self::max(2),
                self::REQUIRED,
            ],
        ];
    }

    #endregion
}
