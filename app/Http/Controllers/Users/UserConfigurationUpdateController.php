<?php

namespace App\Http\Controllers\Users;

#region USE

use App\Http\Requests\Users\UserConfigurationUpdateRequest;
use App\Models\User;
use App\Models\UserConfiguration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserConfigurationUpdateController
{
    #region PUBLIC METHODS

    /**
     * @return RedirectResponse
     */
    public function __invoke(UserConfigurationUpdateRequest $request): RedirectResponse
    {
        $attributes = $request->validated();

        $user = Auth::user();

        $configuration = UserConfiguration::firstOrCreate([
            UserConfiguration::USER_ID => $user->{User::ID},
        ]);

        $configuration->update($attributes);

        return back();
    }

    #endregion
}
