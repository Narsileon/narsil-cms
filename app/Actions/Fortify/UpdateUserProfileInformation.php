<?php

namespace App\Actions\Fortify;

#region USE

use App\Http\Requests\Users\UserProfileUpdateRequest;
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
     * @param array<string,mixed> $input
     *
     * @return void
     */
    public function update(User $user, array $input): void
    {
        $rules = (new UserProfileUpdateRequest())
            ->rules();

        $attributes = Validator::make($input, $rules)
            ->validated();

        $user
            ->forceFill($attributes)
            ->save();
    }

    #endregion
}
