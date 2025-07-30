<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\EmailInput;
use Narsil\Contracts\Fields\PasswordInput;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Forms\UserForm as Contract;
use Narsil\Enums\Fields\AutoCompleteEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserForm extends AbstractForm implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function elements(): array
    {
        return [
            $this->main([
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
                    Field::SETTINGS => app(PasswordInput::class)
                        ->autoComplete(AutoCompleteEnum::NEW_PASSWORD->value)
                        ->required(true)
                        ->toArray(),
                ],
                [
                    Field::HANDLE => User::ATTRIBUTE_PASSWORD_CONFIRMATION,
                    Field::NAME => trans('narsil-cms::validation.attributes.password_confirmation'),
                    Field::SETTINGS => app(PasswordInput::class)
                        ->autoComplete(AutoCompleteEnum::NEW_PASSWORD->value)
                        ->required(true)
                        ->toArray(),
                ],
                [
                    Field::HANDLE => User::FIRST_NAME,
                    Field::NAME => trans('narsil-cms::validation.attributes.first_name'),
                    Field::SETTINGS => app(TextInput::class)
                        ->autoComplete(AutoCompleteEnum::GIVEN_NAME->value)
                        ->required(true)
                        ->toArray(),
                ],
                [
                    Field::HANDLE => User::LAST_NAME,
                    Field::NAME => trans('narsil-cms::validation.attributes.last_name'),
                    Field::SETTINGS => app(TextInput::class)
                        ->autoComplete(AutoCompleteEnum::FAMILY_NAME->value)
                        ->required(true)
                        ->toArray(),
                ],
            ]),
            $this->information([
                [
                    Field::HANDLE => User::ID,
                    Field::NAME => trans('narsil-cms::validation.attributes.id'),
                ],
                [
                    Field::HANDLE => User::CREATED_AT,
                    Field::NAME => trans('narsil-cms::validation.attributes.created_at'),
                ],
                [
                    Field::HANDLE => User::UPDATED_AT,
                    Field::NAME => trans('narsil-cms::validation.attributes.updated_at'),
                ],
            ]),
        ];
    }

    #endregion
}
