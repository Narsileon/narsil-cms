<?php

namespace Narsil\Forms\Resources;

#region USE

use Narsil\Contracts\Fields\Text\EmailFieldSettings;
use Narsil\Contracts\Fields\Text\PasswordFieldSettings;
use Narsil\Contracts\Fields\Text\TextFieldSettings;
use Narsil\Contracts\Forms\Resources\UserForm as Contract;
use Narsil\Enums\Fields\AutoCompleteEnum;
use Narsil\Forms\AbstractForm;
use Narsil\Models\Fields\Field;
use Narsil\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserForm extends AbstractForm implements Contract
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
            new Field([
                Field::HANDLE => User::FIRST_NAME,
                Field::NAME => trans('validation.attributes.first_name'),
                Field::SETTINGS => app(TextFieldSettings::class)
                    ->autoComplete(AutoCompleteEnum::GIVEN_NAME->value)
                    ->required(true)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => User::LAST_NAME,
                Field::NAME => trans('validation.attributes.last_name'),
                Field::SETTINGS => app(TextFieldSettings::class)
                    ->autoComplete(AutoCompleteEnum::FAMILY_NAME->value)
                    ->required(true)
                    ->toArray(),
            ]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function meta(): array
    {
        return [
            new Field([
                Field::HANDLE => User::ID,
                Field::NAME => trans('validation.attributes.id'),
            ]),
            new Field([
                Field::HANDLE => User::CREATED_AT,
                Field::NAME => trans('validation.attributes.created_at'),
            ]),
            new Field([
                Field::HANDLE => User::UPDATED_AT,
                Field::NAME => trans('validation.attributes.updated_at'),
            ]),
        ];
    }

    #endregion
}
