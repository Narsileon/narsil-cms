<?php

namespace App\Http\Forms\Fortify;

#region USE

use App\Enums\Forms\AutoCompleteEnum;
use App\Http\Forms\AbstractForm;
use App\Interfaces\Forms\Fortify\ITwoFactorChallengeForm;
use App\Support\Input;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TwoFactorChallengeForm extends AbstractForm implements ITwoFactorChallengeForm
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
                ->get(),
            (new Input('recovery_code', ''))
                ->autoComplete(AutoCompleteEnum::ONE_TIME_CODE)
                ->get(),
        ];
    }

    #endregion
}
