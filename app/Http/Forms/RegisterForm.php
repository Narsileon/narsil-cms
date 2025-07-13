<?php

namespace App\Http\Forms;

#region USE

use App\Enums\Forms\AutoCompleteEnum;
use App\Enums\Forms\TypeEnum;
use App\Interfaces\Forms\IRegisterForm;
use App\Models\User;
use App\Structures\Input;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RegisterForm extends AbstractForm implements IRegisterForm
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
                ->column(true)
                ->required(true)
                ->get(),
            (new Input(User::ATTRIBUTE_PASSWORD_CONFIRMATION, ''))
                ->type(TypeEnum::PASSWORD)
                ->autoComplete(AutoCompleteEnum::NEW_PASSWORD)
                ->column(true)
                ->required(true)
                ->get(),
            (new Input(User::FIRST_NAME, ''))
                ->autoComplete(AutoCompleteEnum::GIVEN_NAME)
                ->column(true)
                ->required(true)
                ->get(),
            (new Input(User::LAST_NAME, ''))
                ->type(TypeEnum::PASSWORD)
                ->autoComplete(AutoCompleteEnum::FAMILY_NAME)
                ->column(true)
                ->required(true)
                ->get(),
        ];
    }

    #endregion
}
