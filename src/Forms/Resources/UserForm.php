<?php

namespace Narsil\Forms\Resources;

#region USE

use Narsil\Contracts\Fields\Text\EmailField;
use Narsil\Contracts\Fields\Text\PasswordField;
use Narsil\Contracts\Fields\Text\TextField;
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
    public function content(): array
    {
        return [
            new Field([
                Field::HANDLE => User::EMAIL,
                Field::NAME => trans('narsil-cms::validation.attributes.email'),
                Field::SETTINGS => app(EmailField::class)
                    ->required(true)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => User::PASSWORD,
                Field::NAME => trans('narsil-cms::validation.attributes.password'),
                Field::SETTINGS => app(PasswordField::class)
                    ->autoComplete(AutoCompleteEnum::NEW_PASSWORD->value)
                    ->required(true)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => User::ATTRIBUTE_PASSWORD_CONFIRMATION,
                Field::NAME => trans('narsil-cms::validation.attributes.password_confirmation'),
                Field::SETTINGS => app(PasswordField::class)
                    ->autoComplete(AutoCompleteEnum::NEW_PASSWORD->value)
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
            new Field([
                Field::HANDLE => User::LAST_NAME,
                Field::NAME => trans('narsil-cms::validation.attributes.last_name'),
                Field::SETTINGS => app(TextField::class)
                    ->autoComplete(AutoCompleteEnum::FAMILY_NAME->value)
                    ->required(true)
                    ->toArray(),
            ]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function meta(): array
    {
        return [
            new Field([
                Field::HANDLE => User::ID,
                Field::NAME => trans('narsil-cms::validation.attributes.id'),
            ]),
            new Field([
                Field::HANDLE => User::CREATED_AT,
                Field::NAME => trans('narsil-cms::validation.attributes.created_at'),
            ]),
            new Field([
                Field::HANDLE => User::UPDATED_AT,
                Field::NAME => trans('narsil-cms::validation.attributes.updated_at'),
            ]),
        ];
    }

    #endregion
}
