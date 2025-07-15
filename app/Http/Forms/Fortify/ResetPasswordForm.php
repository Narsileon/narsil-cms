<?php

namespace App\Http\Forms\Fortify;

#region USE

use App\Enums\Forms\AutoCompleteEnum;
use App\Enums\Forms\TypeEnum;
use App\Http\Forms\AbstractForm;
use App\Contracts\Forms\Fortify\ResetPasswordForm as Contract;
use App\Models\User;
use App\Support\Forms\Input;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ResetPasswordForm extends AbstractForm implements Contract
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
        ];
    }

    #endregion
}
