<?php

namespace Narsil\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\Text\TextFieldSettings;
use Narsil\Contracts\Forms\Fortify\TwoFactorChallengeForm as Contract;
use Narsil\Enums\Fields\AutoCompleteEnum;
use Narsil\Forms\AbstractForm;
use Narsil\Models\Fields\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TwoFactorChallengeForm extends AbstractForm implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function content(): array
    {
        return [
            new Field([
                Field::HANDLE => 'code',
                Field::NAME => trans('validation.attributes.code'),
                Field::SETTINGS => app(TextFieldSettings::class)
                    ->autoComplete(AutoCompleteEnum::ONE_TIME_CODE->value)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => 'recovery_code',
                Field::NAME => trans('validation.attributes.recovery_code'),
                Field::SETTINGS => app(TextFieldSettings::class)
                    ->autoComplete(AutoCompleteEnum::ONE_TIME_CODE->value)
                    ->toArray(),
            ]),
        ];
    }

    #endregion
}
