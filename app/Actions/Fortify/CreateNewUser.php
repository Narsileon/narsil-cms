<?php

namespace App\Actions\Fortify;

#region USE

use App\Http\Requests\AbstractFormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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
     * @param array<string,string> $input
     *
     * @return User
     */
    public function create(array $input): User
    {
        $attributes = Validator::make($input, [
            User::EMAIL => [
                AbstractFormRequest::STRING,
                AbstractFormRequest::EMAIL,
                AbstractFormRequest::max(255),
                AbstractFormRequest::REQUIRED,
                Rule::unique(User::class),
            ],
            User::FIRST_NAME => [
                AbstractFormRequest::STRING,
                AbstractFormRequest::min(1),
                AbstractFormRequest::max(255),
                AbstractFormRequest::REQUIRED,
            ],
            User::LAST_NAME => [
                AbstractFormRequest::STRING,
                AbstractFormRequest::min(1),
                AbstractFormRequest::max(255),
                AbstractFormRequest::REQUIRED,
            ],
            User::PASSWORD => [
                AbstractFormRequest::STRING,
                AbstractFormRequest::min(8),
                AbstractFormRequest::max(255),
                AbstractFormRequest::REQUIRED,
                AbstractFormRequest::CONFIRMED,
            ],
        ])->validated();

        $user = new User();

        $user->forceFill($attributes)->save();

        return $user;
    }

    #endregion
}
