<?php

namespace Narsil\Actions\Fortify;

#region USE

use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Narsil\Contracts\FormRequests\Fortify\UpdateUserProfileInformationFormRequest;
use Narsil\Models\User;

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
        $rules = app(UpdateUserProfileInformationFormRequest::class)
            ->rules();

        $attributes = Validator::make($input, $rules)
            ->validated();

        $user
            ->forceFill($attributes)
            ->save();
    }

    #endregion
}
