<?php

namespace Narsil\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\Enum\CheckboxFieldSettings;
use Narsil\Contracts\Fields\Text\EmailFieldSettings;
use Narsil\Contracts\Fields\Text\PasswordFieldSettings;
use Narsil\Contracts\Forms\Fortify\LoginForm as Contract;
use Narsil\Enums\Fields\AutoCompleteEnum;
use Narsil\Forms\AbstractForm;
use Narsil\Models\Fields\Field;
use Narsil\Models\User;

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
