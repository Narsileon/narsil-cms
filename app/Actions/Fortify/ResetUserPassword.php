<?php

namespace App\Actions\Fortify;

#region USE

use App\Http\Requests\Users\UserPasswordResetRequest;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ResetUserPassword implements ResetsUserPasswords
{
    #region PUBLIC METHODS

    /**
     * @param User $user
     * @param array<string,string> $input
     *
     * @return void
     */
    public function reset(User $user, array $input): void
    {
        $rules = (new UserPasswordResetRequest())
            ->rules();

        $attributes = Validator::make($input, $rules)
            ->validated();

        $user
            ->forceFill($attributes)
            ->save();
    }

    #endregion
}
