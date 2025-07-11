<?php

namespace App\Http\Requests\Users;

#region USE

use App\Http\Requests\AbstractFormRequest;
use App\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserPasswordResetRequest extends AbstractFormRequest
{
    #region PUBLIC METHODS

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            User::PASSWORD => [
                self::STRING,
                self::min(8),
                self::max(255),
                self::REQUIRED,
                self::CONFIRMED,
            ],
        ];
    }

    #endregion
}
