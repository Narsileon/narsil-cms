<?php

namespace App\Http\Forms\Fortify;

#region USE

use App\Contracts\Forms\Fortify\UpdatePasswordForm as Contract;
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
class UpdatePasswordForm extends AbstractForm implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function getContent(): array
    {
        return [
            (new Input(User::ATTRIBUTE_CURRENT_PASSWORD, TypeEnum::PASSWORD, ''))
                ->setAutoComplete(AutoCompleteEnum::CURRENT_PASSWORD)
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
