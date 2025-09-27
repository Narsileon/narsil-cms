<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Inertia\Response;
use Narsil\Contracts\FormRequests\UserConfigurationFormRequest;
use Narsil\Contracts\Forms\Fortify\ProfileForm;
use Narsil\Contracts\Forms\Fortify\TwoFactorForm;
use Narsil\Contracts\Forms\Fortify\UpdatePasswordForm;
use Narsil\Contracts\Forms\UserConfigurationForm;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Models\User;
use Narsil\Models\Users\UserConfiguration;
use Narsil\Support\LabelsBag;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class UserConfigurationController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @return JsonResponse|Response
     */
    public function index(Request $request): JsonResponse|Response
    {
        $profileForm = app(ProfileForm::class);
        $twoFactorForm = app(TwoFactorForm::class);
        $updatePasswordForm = app(UpdatePasswordForm::class);
        $userConfigurationForm = app(UserConfigurationForm::class);

        app(LabelsBag::class)
            ->add('narsil::sessions.sign_out_current_description')
            ->add('narsil::sessions.sign_out_current')
            ->add('narsil::sessions.sign_out_elsewhere_description')
            ->add('narsil::sessions.sign_out_elsewhere')
            ->add('narsil::sessions.sign_out_everywhere_description')
            ->add('narsil::sessions.sign_out_everywhere')
            ->add('narsil::ui.account')
            ->add('narsil::ui.password')
            ->add('narsil::ui.personalization')
            ->add('narsil::ui.security')
            ->add('narsil::ui.sessions');

        return $this->render(
            component: 'narsil/cms::users/settings',
            title: trans('narsil::ui.settings'),
            description: trans('narsil::ui.settings'),
            props: [
                'profileForm' => $profileForm->jsonSerialize(),
                'twoFactorForm' => $twoFactorForm->jsonSerialize(),
                'updatePasswordForm' => $updatePasswordForm->jsonSerialize(),
                'userConfigurationForm' => $userConfigurationForm->jsonSerialize(),
            ]
        );
    }

    /**
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->all();

        $rules = app(UserconfigurationFormRequest::class)->rules();

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

        if ($locale = Arr::get($attributes, UserConfiguration::LOCALE))
        {
            Session::put(UserConfiguration::LOCALE, $locale);
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
