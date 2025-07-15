<?php

namespace App\Http\Forms\Fortify;

#region USE

use App\Contracts\Forms\Fortify\LoginForm as Contract;
use App\Enums\Forms\AutoCompleteEnum;
use App\Enums\Forms\TypeEnum;
use App\Http\Forms\AbstractForm;
use App\Models\User;
use App\Support\Forms\Input;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class LoginForm extends AbstractForm implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function getContent(): array
    {
        return [
            (new Input(User::EMAIL, TypeEnum::EMAIL, ''))
                ->setAutoComplete(AutoCompleteEnum::EMAIL)
                ->setRequired(true)
                ->get(),
            (new Input(User::PASSWORD, TypeEnum::PASSWORD, ''))
                ->setAutoComplete(AutoCompleteEnum::CURRENT_PASSWORD)
                ->setRequired(true)
                ->get(),
            (new Input(User::REMEMBER, TypeEnum::CHECKBOX, false))
                ->get(),
        ];
    }

    #endregion
}
