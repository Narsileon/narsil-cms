<?php

namespace Narsil\Implementations\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\EmailInput;
use Narsil\Contracts\Fields\PasswordInput;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Forms\Fortify\RegisterForm as Contract;
use Narsil\Enums\Fields\AutoCompleteEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
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
            new Field([
                Field::HANDLE => User::EMAIL,
                Field::NAME => trans('narsil-cms::validation.attributes.email'),
                Field::TYPE => EmailInput::class,
                Field::SETTINGS => app(EmailInput::class)
                    ->required(true),
            ]),
            new Field([
                Field::HANDLE => User::PASSWORD,
                Field::NAME => trans('narsil-cms::validation.attributes.password'),
                Field::TYPE => PasswordInput::class,
                Field::SETTINGS => app(PasswordInput::class)
                    ->className('col-span-6')
                    ->autoComplete(AutoCompleteEnum::NEW_PASSWORD->value)
                    ->required(true),
            ]),
            new Field([
                Field::HANDLE => User::ATTRIBUTE_PASSWORD_CONFIRMATION,
                Field::NAME => trans('narsil-cms::validation.attributes.password_confirmation'),
                Field::TYPE => PasswordInput::class,
                Field::SETTINGS => app(PasswordInput::class)
                    ->className('col-span-6')
                    ->autoComplete(AutoCompleteEnum::NEW_PASSWORD->value)
                    ->required(true),
            ]),
            new Field([
                Field::HANDLE => User::FIRST_NAME,
                Field::NAME => trans('narsil-cms::validation.attributes.first_name'),
                Field::TYPE => TextInput::class,
                Field::SETTINGS => app(TextInput::class)
                    ->className('col-span-6')
                    ->autoComplete(AutoCompleteEnum::GIVEN_NAME->value)
                    ->required(true),
            ]),
            new Field([
                Field::HANDLE => User::LAST_NAME,
                Field::NAME => trans('narsil-cms::validation.attributes.last_name'),
                Field::TYPE => TextInput::class,
                Field::SETTINGS => app(TextInput::class)
                    ->className('col-span-6')
                    ->autoComplete(AutoCompleteEnum::FAMILY_NAME->value)
                    ->required(true),
            ]),
        ];
    }

    #endregion
}
