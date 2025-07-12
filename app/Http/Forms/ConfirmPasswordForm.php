<?php

namespace App\Http\Forms;

#region USE

use App\Enums\Forms\AutoCompleteEnum;
use App\Enums\Forms\TypeEnum;
use App\Interfaces\Forms\IConfirmPasswordForm;
use App\Models\User;
use App\Structures\Input;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ConfirmPasswordForm extends AbstractForm implements IConfirmPasswordForm
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected static function inputs(): array
    {
        return [
            (new Input(user::PASSWORD, ''))
                ->type(TypeEnum::PASSWORD)
                ->autoComplete(AutoCompleteEnum::ONE_TIME_CODE)
                ->required(true)
                ->get(),
        ];
    }

    #endregion
}
