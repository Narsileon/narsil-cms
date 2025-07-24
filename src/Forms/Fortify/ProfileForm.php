<?php

namespace Narsil\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\Text\TextFieldSettings;
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
    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function content(): array
    {
        return [
            new Field([
                Field::HANDLE => User::LAST_NAME,
                Field::NAME => trans('validation.attributes.last_name'),
                Field::SETTINGS => app(TextFieldSettings::class)
                    ->autoComplete(AutoCompleteEnum::FAMILY_NAME->value)
                    ->required(true)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => User::FIRST_NAME,
                Field::NAME => trans('validation.attributes.first_name'),
                Field::SETTINGS => app(TextFieldSettings::class)
                    ->autoComplete(AutoCompleteEnum::GIVEN_NAME->value)
                    ->required(true)
                    ->toArray(),
            ]),
        ];
    }

    #endregion
}
