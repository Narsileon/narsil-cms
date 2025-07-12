<?php

namespace App\Http\Forms;

#region USE

use App\Enums\Forms\AutoCompleteEnum;
use App\Enums\Forms\TypeEnum;
use App\Interfaces\Forms\IForgotPasswordForm;
use App\Models\User;
use App\Structures\Input;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ForgotPasswordForm extends AbstractForm implements IForgotPasswordForm
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected static function inputs(): array
    {
        return [
            (new Input(User::EMAIL, ''))
                ->type(TypeEnum::EMAIL)
                ->autoComplete(AutoCompleteEnum::EMAIL)
                ->description(trans('passwords.instruction'))
                ->required(true)
                ->get(),
        ];
    }

    #endregion
}
