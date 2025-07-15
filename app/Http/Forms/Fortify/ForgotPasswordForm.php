<?php

namespace App\Http\Forms\Fortify;

#region USE

use App\Contracts\Forms\Fortify\ForgotPasswordForm as Contract;
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
class ForgotPasswordForm extends AbstractForm implements Contract
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
                ->setDescription(trans('passwords.instruction'))
                ->setRequired(true)
                ->get(),
        ];
    }

    #endregion
}
