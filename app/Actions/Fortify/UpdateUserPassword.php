<?php

namespace App\Actions\Fortify;

#region USE

use App\Http\Requests\AbstractFormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

#endregion

/**
 * @version 1.0.0
 *
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
        $password = Validator::make($input, [
            User::ATTRIBUTE_CURRENT_PASSWORD => [
                AbstractFormRequest::STRING,
                AbstractFormRequest::REQUIRED,
                'current_password:web'
            ],
            User::PASSWORD => [
                AbstractFormRequest::STRING,
                AbstractFormRequest::min(8),
                AbstractFormRequest::max(255),
                AbstractFormRequest::REQUIRED,
                AbstractFormRequest::CONFIRMED,
            ],
        ])->validated(User::PASSWORD);

        $user
            ->forceFill([
                User::PASSWORD => $password,
            ])
            ->save();
    }

    #endregion
}
