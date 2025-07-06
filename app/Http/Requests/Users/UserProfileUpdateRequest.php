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
class UserProfileUpdateRequest extends AbstractFormRequest
{
    #region PUBLIC METHODS

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            User::FIRST_NAME => [
                AbstractFormRequest::STRING,
                AbstractFormRequest::min(1),
                AbstractFormRequest::max(255),
                AbstractFormRequest::SOMETIMES,
            ],
            User::LAST_NAME => [
                AbstractFormRequest::STRING,
                AbstractFormRequest::min(1),
                AbstractFormRequest::max(255),
                AbstractFormRequest::SOMETIMES,
            ],
        ];
    }

    #endregion
}
