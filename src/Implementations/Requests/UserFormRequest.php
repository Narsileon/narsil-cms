<?php

namespace Narsil\Implementations\Requests;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\File;
use Narsil\Contracts\FormRequests\UserFormRequest as Contract;
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
    public function rules(?Model $model = null): array
    {
        return [
            User::AVATAR => [
                File::image()
                    ->dimensions(
                        FormRule::dimensions()
                            ->maxWidth(2048)
                            ->maxHeight(2048)
                    ),
                FormRule::NULLABLE,
            ],
            User::EMAIL => [
                FormRule::STRING,
                FormRule::EMAIL,
                FormRule::max(255),
                FormRule::REQUIRED,
                FormRule::unique(
                    User::class,
                    User::EMAIL,
                )->ignore($model?->{User::ID}),
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
                FormRule::CONFIRMED,
                $model ? FormRule::SOMETIMES : FormRule::REQUIRED
            ],
        ];
    }

    #endregion
}
