<?php

namespace App\Forms\Fortify;

#region USE

use App\Contracts\Fields\Enum\CheckboxFieldSettings;
use App\Contracts\Fields\Text\EmailFieldSettings;
use App\Contracts\Fields\Text\PasswordFieldSettings;
use App\Contracts\Forms\Fortify\LoginForm as Contract;
use App\Enums\Fields\AutoCompleteEnum;
use App\Forms\AbstractForm;
use App\Models\Fields\Field;
use App\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class LoginForm extends AbstractForm implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function content(): array
    {
        return [
            new Field([
                Field::HANDLE => User::EMAIL,
                Field::NAME => trans('validation.attributes.email'),
                Field::SETTINGS => app(EmailFieldSettings::class)
                    ->autoComplete(AutoCompleteEnum::EMAIL->value)
                    ->required(true)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => User::PASSWORD,
                Field::NAME => trans('validation.attributes.password'),
                Field::SETTINGS => app(PasswordFieldSettings::class)
                    ->autoComplete(AutoCompleteEnum::CURRENT_PASSWORD->value)
                    ->required(true)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => User::REMEMBER,
                Field::NAME => trans('validation.attributes.remember'),
                Field::SETTINGS => app(CheckboxFieldSettings::class)
                    ->toArray(),
            ]),
        ];
    }

    #endregion
}
