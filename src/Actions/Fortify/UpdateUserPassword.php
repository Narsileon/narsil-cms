<?php

namespace Narsil\Actions\Fortify;

#region USE

use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Narsil\Contracts\FormRequests\Fortify\UpdateUserPasswordFormRequest;
use Narsil\Models\User;

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
        $rules = app(UpdateUserPasswordFormRequest::class)
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
