<?php

namespace App\Http\Forms\Resources;

#region USE

use App\Enums\Forms\AutoCompleteEnum;
use App\Enums\Forms\TypeEnum;
use App\Http\Forms\AbstractForm;
use App\Interfaces\Forms\Resources\IUserForm;
use App\Models\User;
use App\Support\Input;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserForm extends AbstractForm implements IUserForm
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
            (new Input(User::FIRST_NAME, ''))
                ->autoComplete(AutoCompleteEnum::GIVEN_NAME)
                ->required(true)
                ->get(),
            (new Input(User::LAST_NAME, ''))
                ->autoComplete(AutoCompleteEnum::FAMILY_NAME)
                ->required(true)
                ->get(),
        ];
    }

    #endregion
}
