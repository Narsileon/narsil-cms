<?php

namespace App\Http\Forms\Resources;

#region USE

use App\Contracts\Forms\Resources\UserForm as Contract;
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
class UserForm extends AbstractForm implements Contract
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
                ->setRequired(true)
                ->get(),
            (new Input(User::ATTRIBUTE_PASSWORD_CONFIRMATION, TypeEnum::PASSWORD, ''))
                ->setAutoComplete(AutoCompleteEnum::NEW_PASSWORD)
                ->setRequired(true)
                ->get(),
            (new Input(User::FIRST_NAME, TypeEnum::TEXT, ''))
                ->setAutoComplete(AutoCompleteEnum::GIVEN_NAME)
                ->setRequired(true)
                ->get(),
            (new Input(User::LAST_NAME, TypeEnum::TEXT, ''))
                ->setAutoComplete(AutoCompleteEnum::FAMILY_NAME)
                ->setRequired(true)
                ->get(),
        ];
    }

    #endregion
}
