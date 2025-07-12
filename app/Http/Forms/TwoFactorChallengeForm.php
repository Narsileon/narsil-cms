<?php

namespace App\Http\Forms;

#region USE

use App\Enums\Forms\AutoCompleteEnum;
use App\Interfaces\Forms\ITwoFactorChallengeForm;
use App\Structures\Input;

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
    protected static function inputs(): array
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
