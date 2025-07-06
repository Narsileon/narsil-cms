<?php

namespace App\Http\Forms;

#region USE

use App\Enums\Forms\AutoCompleteEnum;
use App\Enums\Forms\TypeEnum;
use App\Models\User;
use App\Structures\Input;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class LoginForm extends AbstractForm
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected static function inputs(): array
    {
        return [
            (new Input(User::EMAIL))
                ->type(TypeEnum::EMAIL)
                ->autoComplete(AutoCompleteEnum::EMAIL)
                ->required(true)
                ->get(),
            (new Input(user::PASSWORD))
                ->type(TypeEnum::PASSWORD)
                ->autoComplete(AutoCompleteEnum::CURRENT_PASSWORD)
                ->required(true)
                ->get(),
            (new Input(User::REMEMBER))
                ->type(TypeEnum::CHECKBOX)
                ->get(),
        ];
    }

    #endregion
}
