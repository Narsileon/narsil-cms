<?php

namespace App\Http\Requests\Fortify;

#region USE

use App\Contracts\FormRequests\Fortify\UpdateUserPasswordFormRequest as Contract;
use App\Models\User;
use App\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UpdateUserPasswordFormRequest implements Contract
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
