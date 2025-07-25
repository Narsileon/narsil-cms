<?php

namespace Narsil\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\Text\TextField;
use Narsil\Contracts\Forms\Fortify\ProfileForm as Contract;
use Narsil\Enums\Fields\AutoCompleteEnum;
use Narsil\Forms\AbstractForm;
use Narsil\Models\Fields\Field;
use Narsil\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ProfileForm extends AbstractForm implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function content(): array
    {
        return [
            new Field([
                Field::HANDLE => User::LAST_NAME,
                Field::NAME => trans('narsil-cms::validation.attributes.last_name'),
                Field::SETTINGS => app(TextField::class)
                    ->autoComplete(AutoCompleteEnum::FAMILY_NAME->value)
                    ->required(true)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => User::FIRST_NAME,
                Field::NAME => trans('narsil-cms::validation.attributes.first_name'),
                Field::SETTINGS => app(TextField::class)
                    ->autoComplete(AutoCompleteEnum::GIVEN_NAME->value)
                    ->required(true)
                    ->toArray(),
            ]),
        ];
    }

    #endregion
}
