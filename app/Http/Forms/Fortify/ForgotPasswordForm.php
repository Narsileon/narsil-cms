<?php

namespace App\Http\Forms\Fortify;

#region USE

use App\Contracts\Fields\Text\EmailFieldSettings;
use App\Contracts\Forms\Fortify\ForgotPasswordForm as Contract;
use App\Enums\Fields\AutoCompleteEnum;
use App\Http\Forms\AbstractForm;
use App\Models\Fields\Field;
use App\Models\User;

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
    protected function getContent(): array
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
