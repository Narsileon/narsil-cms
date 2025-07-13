<?php

namespace App\Http\Forms\Fortify;

#region USE

use App\Enums\Forms\AutoCompleteEnum;
use App\Http\Forms\AbstractForm;
use App\Interfaces\Forms\Fortify\ITwoFactorForm;
use App\Support\Input;

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
     * {@inheritdoc}
     */
    protected function getLabels(): array
    {
        return array_merge(parent::getLabels(), [
            'code_invalid'               => trans('validation.custom.code.invalid'),
            'recovery_codes_copied'      => trans('two-factor.recovery_codes_copied'),
            'recovery_codes_description' => trans('two-factor.recovery_codes_description'),
            'recovery_codes_title'       => trans('two-factor.recovery_codes_title'),
            'two_factor_authentication'  => trans('two-factor.two_factor_authentication'),
        ]);
    }

    #endregion
}
