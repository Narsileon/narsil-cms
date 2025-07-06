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
                AbstractFormRequest::STRING,
                AbstractFormRequest::EMAIL,
                AbstractFormRequest::max(255),
                AbstractFormRequest::REQUIRED,
                Rule::unique(User::class),
            ],
            User::FIRST_NAME => [
                AbstractFormRequest::STRING,
                AbstractFormRequest::min(1),
                AbstractFormRequest::max(255),
                AbstractFormRequest::REQUIRED,
            ],
            User::LAST_NAME => [
                AbstractFormRequest::STRING,
                AbstractFormRequest::min(1),
                AbstractFormRequest::max(255),
                AbstractFormRequest::REQUIRED,
            ],
            User::PASSWORD => [
                AbstractFormRequest::STRING,
                AbstractFormRequest::min(8),
                AbstractFormRequest::max(255),
                AbstractFormRequest::REQUIRED,
                AbstractFormRequest::CONFIRMED,
            ],
        ];
    }

    #endregion
}
