<?php

namespace Narsil\Actions\Fortify;

#region USE

use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Narsil\Contracts\FormRequests\Fortify\CreateNewUserFormRequest;
use Narsil\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class CreateNewUser implements CreatesNewUsers
{
    #region PUBLIC METHODS

    /**
     * @param array<string,mixed> $input
     *
     * @return User
     */
    public function create(array $input): User
    {
        $rules = app(CreateNewUserFormRequest::class)
            ->rules();

        $attributes = Validator::make($input, $rules)
            ->validated();

        $user = new User();

        $user
            ->forceFill($attributes)
            ->save();

        return $user;
    }

    #endregion
}
