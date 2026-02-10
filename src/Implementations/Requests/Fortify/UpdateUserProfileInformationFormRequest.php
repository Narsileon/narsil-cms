<?php

namespace Narsil\Cms\Implementations\Requests\Fortify;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\File;
use Narsil\Base\Validation\FormRule;
use Narsil\Cms\Contracts\Requests\Fortify\UpdateUserProfileInformationFormRequest as Contract;
use Narsil\Cms\Models\User;

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
            User::AVATAR => [
                File::image()
                    ->dimensions(
                        FormRule::dimensions()
                            ->maxWidth(2048)
                            ->maxHeight(2048)
                    ),
                FormRule::NULLABLE,
            ],
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
