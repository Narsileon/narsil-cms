<?php

namespace Narsil\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\Text\EmailFieldSettings;
use Narsil\Contracts\Forms\Fortify\ForgotPasswordForm as Contract;
use Narsil\Enums\Fields\AutoCompleteEnum;
use Narsil\Forms\AbstractForm;
use Narsil\Models\Fields\Field;
use Narsil\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ForgotPasswordForm extends AbstractForm implements Contract
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
                Field::DESCRIPTION => trans('passwords.instruction'),
                Field::SETTINGS => app(EmailFieldSettings::class)
                    ->autoComplete(AutoCompleteEnum::EMAIL->value)
                    ->required(true)
                    ->toArray(),
            ]),
        ];
    }

    #endregion
}
