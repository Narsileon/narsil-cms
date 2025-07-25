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
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function fields(): array
    {
        return [
            [
                Field::HANDLE => self::MAIN,
                Field::RELATION_FIELDS => [
                    [
                        Field::HANDLE => User::EMAIL,
                        Field::NAME => trans('narsil-cms::validation.attributes.email'),
                        Field::SETTINGS => app(EmailField::class)
                            ->required(true)
                            ->toArray(),
                    ],
                    [
                        Field::HANDLE => User::PASSWORD,
                        Field::NAME => trans('narsil-cms::validation.attributes.password'),
                        Field::SETTINGS => app(PasswordField::class)
                            ->autoComplete(AutoCompleteEnum::NEW_PASSWORD->value)
                            ->required(true)
                            ->toArray(),
                    ],
                    [
                        Field::HANDLE => User::ATTRIBUTE_PASSWORD_CONFIRMATION,
                        Field::NAME => trans('narsil-cms::validation.attributes.password_confirmation'),
                        Field::SETTINGS => app(PasswordField::class)
                            ->autoComplete(AutoCompleteEnum::NEW_PASSWORD->value)
                            ->required(true)
                            ->toArray(),
                    ],
                    [
                        Field::HANDLE => User::FIRST_NAME,
                        Field::NAME => trans('narsil-cms::validation.attributes.first_name'),
                        Field::SETTINGS => app(TextField::class)
                            ->autoComplete(AutoCompleteEnum::GIVEN_NAME->value)
                            ->required(true)
                            ->toArray(),
                    ],
                    [
                        Field::HANDLE => User::LAST_NAME,
                        Field::NAME => trans('narsil-cms::validation.attributes.last_name'),
                        Field::SETTINGS => app(TextField::class)
                            ->autoComplete(AutoCompleteEnum::FAMILY_NAME->value)
                            ->required(true)
                            ->toArray(),
                    ],
                ],
            ],
            [
                Field::HANDLE => self::DATA,
                Field::RELATION_FIELDS => [
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
