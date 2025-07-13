<?php

namespace App\Http\Forms;

#region USE

use App\Enums\Forms\AutoCompleteEnum;
use App\Enums\Forms\TypeEnum;
use App\Interfaces\Forms\IResetPasswordForm;
use App\Models\User;
use App\Structures\Input;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ResetPasswordForm extends AbstractForm implements IResetPasswordForm
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function getInputs(): array
    {
        return [
            (new Input(User::EMAIL, ''))
                ->type(TypeEnum::EMAIL)
                ->autoComplete(AutoCompleteEnum::EMAIL)
                ->required(true)
                ->get(),
            (new Input(User::PASSWORD, ''))
                ->type(TypeEnum::PASSWORD)
                ->autoComplete(AutoCompleteEnum::NEW_PASSWORD)
                ->required(true)
                ->get(),
            (new Input(User::ATTRIBUTE_PASSWORD_CONFIRMATION, ''))
                ->type(TypeEnum::PASSWORD)
                ->autoComplete(AutoCompleteEnum::NEW_PASSWORD)
                ->required(true)
                ->get(),
        ];
    }

    #endregion
}
