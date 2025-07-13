<?php

namespace App\Http\Forms\Fortify;

#region USE

use App\Enums\Forms\AutoCompleteEnum;
use App\Enums\Forms\TypeEnum;
use App\Http\Forms\AbstractForm;
use App\Interfaces\Forms\Fortify\IProfileForm;
use App\Models\User;
use App\Support\Input;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ProfileForm extends AbstractForm implements IProfileForm
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function getInputs(): array
    {
        return [
            (new Input(User::LAST_NAME, ''))
                ->autoComplete(AutoCompleteEnum::FAMILY_NAME)
                ->column(true)
                ->required(true)
                ->get(),
            (new Input(User::FIRST_NAME, ''))
                ->autoComplete(AutoCompleteEnum::GIVEN_NAME)
                ->column(true)
                ->required(true)
                ->get(),

        ];
    }

    #endregion
}
