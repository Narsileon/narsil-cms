<?php

namespace Narsil\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\Select\CheckboxField;
use Narsil\Contracts\Fields\Text\EmailField;
use Narsil\Contracts\Fields\Text\PasswordField;
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
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function fields(): array
    {
        return [
            [
                Field::HANDLE => User::EMAIL,
                Field::NAME => trans('narsil-cms::validation.attributes.email'),
                Field::SETTINGS => app(EmailField::class)
                    ->autoComplete(AutoCompleteEnum::EMAIL->value)
                    ->required(true)
                    ->toArray(),
            ],
            [
                Field::HANDLE => User::PASSWORD,
                Field::NAME => trans('narsil-cms::validation.attributes.password'),
                Field::SETTINGS => app(PasswordField::class)
                    ->autoComplete(AutoCompleteEnum::CURRENT_PASSWORD->value)
                    ->required(true)
                    ->toArray(),
            ],
            [
                Field::HANDLE => User::REMEMBER,
                Field::NAME => trans('narsil-cms::validation.attributes.remember'),
                Field::SETTINGS => app(CheckboxField::class)
                    ->toArray(),
            ],
        ];
    }

    #endregion
}
