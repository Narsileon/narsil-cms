<?php

namespace App\Http\Forms\Fortify;

#region USE

use App\Contracts\Forms\Fortify\TwoFactorChallengeForm as Contract;
use App\Enums\Forms\AutoCompleteEnum;
use App\Enums\Forms\TypeEnum;
use App\Http\Forms\AbstractForm;
use App\Support\Forms\Input;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TwoFactorChallengeForm extends AbstractForm implements Contract
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
                ->get(),
            (new Input('recovery_code', TypeEnum::TEXT, ''))
                ->setAutoComplete(AutoCompleteEnum::ONE_TIME_CODE)
                ->get(),
        ];
    }

    #endregion
}
