<?php

namespace Narsil\Cms\Implementations\Requests\Fortify;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Cms\Contracts\Requests\Fortify\UpdateUserPasswordFormRequest as Contract;
use Narsil\Cms\Models\User;
use Narsil\Cms\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UpdateUserPasswordFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(?Model $model = null): array
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
