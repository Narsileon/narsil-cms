<?php

namespace Narsil\Implementations\Forms\Fortify;

#region USE

use Narsil\Contracts\FormElements\EmailInput;
use Narsil\Contracts\FormElements\PasswordInput;
use Narsil\Contracts\FormElements\TextInput;
use Narsil\Contracts\Forms\Fortify\RegisterForm as Contract;
use Narsil\Enums\Fields\AutoCompleteEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Fields\Field;
use Narsil\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RegisterForm extends AbstractForm implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function elements(): array
    {
        return [
            [
                Field::HANDLE => User::EMAIL,
                Field::NAME => trans('narsil-cms::validation.attributes.email'),
                Field::SETTINGS => app(EmailInput::class)
                    ->required(true)
                    ->toArray(),
            ],
            [
                Field::HANDLE => User::PASSWORD,
                Field::NAME => trans('narsil-cms::validation.attributes.password'),
                Field::WIDTH => 50,
                Field::SETTINGS => app(PasswordInput::class)
                    ->autoComplete(AutoCompleteEnum::NEW_PASSWORD->value)
                    ->required(true)
                    ->toArray(),
            ],
            [
                Field::HANDLE => User::ATTRIBUTE_PASSWORD_CONFIRMATION,
                Field::NAME => trans('narsil-cms::validation.attributes.password_confirmation'),
                Field::WIDTH => 50,
                Field::SETTINGS => app(PasswordInput::class)
                    ->autoComplete(AutoCompleteEnum::NEW_PASSWORD->value)
                    ->required(true)
                    ->toArray(),
            ],
            [
                Field::HANDLE => User::FIRST_NAME,
                Field::NAME => trans('narsil-cms::validation.attributes.first_name'),
                Field::WIDTH => 50,
                Field::SETTINGS => app(TextInput::class)
                    ->autoComplete(AutoCompleteEnum::GIVEN_NAME->value)
                    ->required(true)
                    ->toArray(),
            ],
            [
                Field::HANDLE => User::LAST_NAME,
                Field::NAME => trans('narsil-cms::validation.attributes.last_name'),
                Field::WIDTH => 50,
                Field::SETTINGS => app(TextInput::class)
                    ->autoComplete(AutoCompleteEnum::FAMILY_NAME->value)
                    ->required(true)
                    ->toArray(),
            ],
        ];
    }

    #endregion
}
