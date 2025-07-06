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
class UserPasswordUpdateRequest extends AbstractFormRequest
{
    #region PUBLIC METHODS

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            User::ATTRIBUTE_CURRENT_PASSWORD => [
                AbstractFormRequest::STRING,
                AbstractFormRequest::REQUIRED,
                'current_password:web'
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
