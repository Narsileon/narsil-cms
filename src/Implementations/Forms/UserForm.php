<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\FormElements\EmailInput;
use Narsil\Contracts\FormElements\PasswordInput;
use Narsil\Contracts\FormElements\TextInput;
use Narsil\Contracts\Forms\UserForm as Contract;
use Narsil\Enums\Fields\AutoCompleteEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Fields\Field;
use Narsil\Models\Fields\FieldSet;
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
    public function fields(): array
    {
        return [
            [
                FieldSet::HANDLE => self::MAIN,
                FieldSet::NAME => trans('narsil-cms::ui.main'),
                FieldSet::RELATION_ELEMENTS => [
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
                ],
            ],
            [
                FieldSet::HANDLE => self::SIDEBAR_INFORMATION,
                FieldSet::RELATION_ELEMENTS => [
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
                ],
            ],
        ];
    }

    #endregion
}
