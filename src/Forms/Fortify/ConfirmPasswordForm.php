<?php

namespace Narsil\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\Text\PasswordFieldSettings;
use Narsil\Contracts\Forms\Fortify\ConfirmPasswordForm as Contract;
use Narsil\Enums\Fields\AutoCompleteEnum;
use Narsil\Forms\AbstractForm;
use Narsil\Models\Fields\Field;
use Narsil\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ConfirmPasswordForm extends AbstractForm implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function content(): array
    {
        return [
            new Field([
                Field::HANDLE => User::PASSWORD,
                Field::NAME => trans('validation.attributes.password'),
                Field::SETTINGS => app(PasswordFieldSettings::class)
                    ->autoComplete(AutoCompleteEnum::ONE_TIME_CODE->value)
                    ->required(true)
                    ->toArray(),
            ]),
        ];
    }

    #endregion
}
