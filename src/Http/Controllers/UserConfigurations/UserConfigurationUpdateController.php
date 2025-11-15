<?php

namespace Narsil\Http\Controllers\UserConfigurations;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\UserConfigurationFormRequest;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\User;
use Narsil\Models\Users\UserConfiguration;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserConfigurationUpdateController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @return RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $data = $request->all();

        $rules = app(UserconfigurationFormRequest::class)
            ->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        if ($user = Auth::user())
        {
            $configuration = UserConfiguration::query()
                ->firstWhere([
                    UserConfiguration::USER_ID => $user->{User::ID},
                ]);

            $configuration?->update($attributes);
        }

        if ($color = Arr::get($attributes, UserConfiguration::COLOR))
        {
            Session::put(UserConfiguration::COLOR, $color);
        }

        if ($language = Arr::get($attributes, UserConfiguration::LANGUAGE))
        {
            Session::put(UserConfiguration::LANGUAGE, $language);
        }

        if ($radius = Arr::get($attributes, UserConfiguration::RADIUS))
        {
            Session::put(UserConfiguration::RADIUS, $radius);
        }

        if ($theme = Arr::get($attributes, UserConfiguration::THEME))
        {
            Session::put(UserConfiguration::THEME, $theme);
        }

        return back();
    }

    #endregion
}
