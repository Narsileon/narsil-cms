<?php

namespace Narsil\Http\Requests\Resources;

#region USE

use Narsil\Contracts\FormRequests\Resources\UserFormRequest as Contract;
use Narsil\Models\User;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            User::EMAIL => [
                FormRule::STRING,
                FormRule::EMAIL,
                FormRule::max(255),
                FormRule::REQUIRED,
                FormRule::unique(User::class),
            ],
            User::FIRST_NAME => [
                FormRule::STRING,
                FormRule::min(1),
                FormRule::max(255),
                FormRule::REQUIRED,
            ],
            User::LAST_NAME => [
                FormRule::STRING,
                FormRule::min(1),
                FormRule::max(255),
                FormRule::REQUIRED,
            ],
            User::PASSWORD => [
                FormRule::STRING,
                FormRule::min(8),
                FormRule::max(255),
                FormRule::NULLABLE,
                FormRule::SOMETIMES,
                FormRule::CONFIRMED,
            ],
        ];
    }

    #endregion
}
