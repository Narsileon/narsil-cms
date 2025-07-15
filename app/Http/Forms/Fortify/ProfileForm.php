<?php

namespace App\Http\Forms\Fortify;

#region USE

use App\Contracts\Forms\Fortify\ProfileForm as Contract;
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
class ProfileForm extends AbstractForm implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function getContent(): array
    {
        return [
            (new Input(User::LAST_NAME, TypeEnum::TEXT, ''))
                ->setAutoComplete(AutoCompleteEnum::FAMILY_NAME)
                ->setColumn(true)
                ->setRequired(true)
                ->get(),
            (new Input(User::FIRST_NAME, TypeEnum::TEXT, ''))
                ->setAutoComplete(AutoCompleteEnum::GIVEN_NAME)
                ->setColumn(true)
                ->setRequired(true)
                ->get(),

        ];
    }

    #endregion
}
