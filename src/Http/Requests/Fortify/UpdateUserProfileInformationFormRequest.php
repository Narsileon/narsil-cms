<?php

namespace Narsil\Http\Requests\Fortify;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\FormRequests\Fortify\UpdateUserProfileInformationFormRequest as Contract;
use Narsil\Models\User;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UpdateUserProfileInformationFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(?Model $model = null): array
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
