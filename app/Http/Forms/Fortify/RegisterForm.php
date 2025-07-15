<?php

namespace App\Http\Forms\Fortify;

#region USE

use App\Contracts\Forms\Fortify\RegisterForm as Contract;
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
class RegisterForm extends AbstractForm implements Contract
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
                ->setAutoComplete(AutoCompleteEnum::NEW_PASSWORD)
                ->setColumn(true)
                ->setRequired(true)
                ->get(),
            (new Input(User::ATTRIBUTE_PASSWORD_CONFIRMATION, TypeEnum::PASSWORD, ''))
                ->setAutoComplete(AutoCompleteEnum::NEW_PASSWORD)
                ->setColumn(true)
                ->setRequired(true)
                ->get(),
            (new Input(User::FIRST_NAME, TypeEnum::TEXT, ''))
                ->setAutoComplete(AutoCompleteEnum::GIVEN_NAME)
                ->setColumn(true)
                ->setRequired(true)
                ->get(),
            (new Input(User::LAST_NAME, TypeEnum::TEXT, ''))
                ->setAutoComplete(AutoCompleteEnum::FAMILY_NAME)
                ->setColumn(true)
                ->setRequired(true)
                ->get(),
        ];
    }

    #endregion
}
