<?php

namespace App\Http\Forms\Fortify;

#region USE

use App\Contracts\Forms\Fortify\ConfirmPasswordForm as Contract;
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
class ConfirmPasswordForm extends AbstractForm implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function getContent(): array
    {
        return [
            (new Input(user::PASSWORD, TypeEnum::PASSWORD, ''))
                ->setAutoComplete(AutoCompleteEnum::ONE_TIME_CODE)
                ->setRequired(true)
                ->get(),
        ];
    }

    #endregion
}
