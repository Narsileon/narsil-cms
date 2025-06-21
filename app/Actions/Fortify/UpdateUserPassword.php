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
    use PasswordValidationRules;

    #region CONSTANTS

    /**
     * @var string
     */
    private const CURRENT_PASSWORD_WEB = "current_password:web";

    #endregion

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
                self::CURRENT_PASSWORD_WEB,
                AbstractFormRequest::REQUIRED,
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
