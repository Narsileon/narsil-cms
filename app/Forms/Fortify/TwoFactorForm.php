<?php

namespace App\Forms\Fortify;

#region USE

use App\Contracts\Fields\Text\TextFieldSettings;
use App\Contracts\Forms\Fortify\TwoFactorForm as Contract;
use App\Enums\Fields\AutoCompleteEnum;
use App\Forms\AbstractForm;
use App\Models\Fields\Field;
use App\Support\LabelsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TwoFactorForm extends AbstractForm implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function content(): array
    {
        return [
            new Field([
                Field::DESCRIPTION => trans('two-factor.code_description'),
                Field::HANDLE => 'code',
                Field::NAME => trans('validation.attributes.code'),
                Field::SETTINGS => app(TextFieldSettings::class)
                    ->autoComplete(AutoCompleteEnum::ONE_TIME_CODE->value)
                    ->className('col-span-1')
                    ->required(true)
                    ->toArray(),
            ]),
        ];
    }

    /**
     * @return void
     */
    protected function registerLabels(): void
    {
        parent::registerLabels();

        app(LabelsBag::class)
            ->add('validation.custom.code.invalid')
            ->add('two-factor.recovery_codes_copied')
            ->add('two-factor.recovery_codes_description')
            ->add('two-factor.recovery_codes_title')
            ->add('two-factor.two_factor_authentication');
    }

    #endregion
}
