<?php

namespace App\Http\Requests\Users;

#region USE

use App\Interfaces\FormRequests\IFormRequest;
use App\Models\User;
use App\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserPasswordUpdateRequest implements IFormRequest
{
    #region PUBLIC METHODS

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            User::ATTRIBUTE_CURRENT_PASSWORD => [
                FormRule::STRING,
                FormRule::REQUIRED,
                'current_password:web'
            ],
            User::PASSWORD => [
                FormRule::STRING,
                FormRule::min(8),
                FormRule::max(255),
                FormRule::REQUIRED,
                FormRule::CONFIRMED,
            ],
        ];
    }

    #endregion
}
