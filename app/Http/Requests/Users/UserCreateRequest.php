<?php

namespace App\Http\Requests\Users;

#region USE

use App\Http\Requests\AbstractFormRequest;
use App\Models\User;
use Illuminate\Validation\Rule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserCreateRequest extends AbstractFormRequest
{
    #region PUBLIC METHODS

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            User::EMAIL => [
                self::STRING,
                self::EMAIL,
                self::max(255),
                self::REQUIRED,
                Rule::unique(User::class),
            ],
            User::FIRST_NAME => [
                self::STRING,
                self::min(1),
                self::max(255),
                self::REQUIRED,
            ],
            User::LAST_NAME => [
                self::STRING,
                self::min(1),
                self::max(255),
                self::REQUIRED,
            ],
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
