<?php

namespace App\Actions\Fortify;

#region USE

use App\Http\Requests\Users\UserPasswordUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UpdateUserPassword implements UpdatesUserPasswords
{
    #region PUBLIC METHODS

    /**
     * @param User $user
     * @param array<string,string> $input
     *
     * @return void
     */
    public function update(User $user, array $input): void
    {
        $rules = (new UserPasswordUpdateRequest())
            ->rules();

        $attributes = Validator::make($input, $rules)
            ->validated();

        $user
            ->forceFill([
                User::PASSWORD => $attributes[User::PASSWORD],
            ])
            ->save();
    }

    #endregion
}
