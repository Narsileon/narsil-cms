<?php

namespace Narsil\Actions\Fortify;

#region USE

use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\ResetsUserPasswords;
use Narsil\Contracts\FormRequests\Fortify\ResetUserPasswordFormRequest;
use Narsil\Models\User;

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
        $rules = app(ResetUserPasswordFormRequest::class)
            ->rules();

        $attributes = Validator::make($input, $rules)
            ->validated();

        $user
            ->forceFill($attributes)
            ->save();
    }

    #endregion
}
