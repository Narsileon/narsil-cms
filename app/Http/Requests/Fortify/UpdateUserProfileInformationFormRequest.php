<?php

namespace App\Http\Requests\Fortify;

#region USE

use App\Contracts\FormRequests\Fortify\UpdateUserProfileInformationFormRequest as Contract;
use App\Models\User;
use App\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UpdateUserProfileInformationFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            User::FIRST_NAME => [
                FormRule::STRING,
                FormRule::min(1),
                FormRule::max(255),
                FormRule::SOMETIMES,
            ],
            User::LAST_NAME => [
                FormRule::STRING,
                FormRule::min(1),
                FormRule::max(255),
                FormRule::SOMETIMES,
            ],
        ];
    }

    #endregion
}
