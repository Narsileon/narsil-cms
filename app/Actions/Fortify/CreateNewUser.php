<?php

namespace App\Actions\Fortify;

#region USE

use App\Http\Requests\Users\UserCreateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

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
        $rules = (new UserCreateRequest())
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
