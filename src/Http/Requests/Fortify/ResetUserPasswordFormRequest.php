<?php

namespace Narsil\Http\Requests\Fortify;

#region USE

use Narsil\Contracts\FormRequests\Fortify\ResetUserPasswordFormRequest as Contract;
use Narsil\Models\User;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ResetUserPasswordFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
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
