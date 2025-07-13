<?php

namespace App\Http\Forms\Fortify;

#region USE

use App\Enums\Forms\AutoCompleteEnum;
use App\Http\Forms\AbstractForm;
use App\Interfaces\Forms\Fortify\ITwoFactorForm;
use App\Support\Input;
use App\Support\LabelsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TwoFactorForm extends AbstractForm implements ITwoFactorForm
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function getInputs(): array
    {
        return [
            (new Input('code', ''))
                ->autoComplete(AutoCompleteEnum::ONE_TIME_CODE)
                ->column(true)
                ->description(trans('two-factor.code_description'))
                ->required(true)
                ->get(),
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
