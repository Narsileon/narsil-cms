<?php

namespace App\Actions\Fortify;

#region USE

use App\Http\Requests\AbstractFormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UpdateUserProfileInformation implements UpdatesUserProfileInformation
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
        $attributes = Validator::make($input, [
            User::FIRST_NAME => [
                AbstractFormRequest::STRING,
                AbstractFormRequest::min(1),
                AbstractFormRequest::max(255),
                AbstractFormRequest::SOMETIMES,
            ],
            User::LAST_NAME => [
                AbstractFormRequest::STRING,
                AbstractFormRequest::min(1),
                AbstractFormRequest::max(255),
                AbstractFormRequest::SOMETIMES,
            ],
        ])->validated();

        $user
            ->forceFill($attributes)
            ->save();
    }

    #endregion
}
