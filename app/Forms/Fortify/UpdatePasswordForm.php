<?php

namespace App\Forms\Fortify;

#region USE

use App\Contracts\Fields\Text\PasswordFieldSettings;
use App\Contracts\Forms\Fortify\UpdatePasswordForm as Contract;
use App\Enums\Fields\AutoCompleteEnum;
use App\Forms\AbstractForm;
use App\Models\Fields\Field;
use App\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UpdatePasswordForm extends AbstractForm implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function content(): array
    {
        return [
            new Field([
                Field::HANDLE => User::ATTRIBUTE_CURRENT_PASSWORD,
                Field::NAME => trans('validation.attributes.current_password'),
                Field::SETTINGS => app(PasswordFieldSettings::class)
                    ->autoComplete(AutoCompleteEnum::CURRENT_PASSWORD->value)
                    ->required(true)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => User::PASSWORD,
                Field::NAME => trans('validation.attributes.password'),
                Field::SETTINGS => app(PasswordFieldSettings::class)
                    ->autoComplete(AutoCompleteEnum::NEW_PASSWORD->value)
                    ->required(true)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => User::ATTRIBUTE_PASSWORD_CONFIRMATION,
                Field::NAME => trans('validation.attributes.password_confirmation'),
                Field::SETTINGS => app(PasswordFieldSettings::class)
                    ->autoComplete(AutoCompleteEnum::NEW_PASSWORD->value)
                    ->required(true)
                    ->toArray(),
            ]),
        ];
    }

    #endregion
}
