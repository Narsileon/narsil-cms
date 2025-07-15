<?php

namespace App\Http\Forms\Fortify;

#region USE

use App\Contracts\Forms\Fortify\TwoFactorForm as Contract;
use App\Enums\Forms\AutoCompleteEnum;
use App\Enums\Forms\TypeEnum;
use App\Http\Forms\AbstractForm;
use App\Support\Forms\Input;
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
     * {@inheritdoc}
     */
    protected function getContent(): array
    {
        return [
            (new Input('code', TypeEnum::TEXT, ''))
                ->setAutoComplete(AutoCompleteEnum::ONE_TIME_CODE)
                ->setColumn(true)
                ->setDescription(trans('two-factor.code_description'))
                ->setRequired(true)
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
