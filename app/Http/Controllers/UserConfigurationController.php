<?php

namespace App\Http\Controllers;

#region USE

use App\Enums\Forms\MethodEnum;
use App\Http\Middleware\LocaleMiddleware;
use App\Interfaces\FormRequests\IUserConfigurationFormRequest;
use App\Interfaces\Forms\Fortify\IProfileForm;
use App\Interfaces\Forms\Fortify\ITwoFactorForm;
use App\Interfaces\Forms\Fortify\IUpdatePasswordForm;
use App\Interfaces\Forms\IUserConfigurationForm;
use App\Models\User;
use App\Models\UserConfiguration;
use App\Narsil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Response;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserConfigurationController extends AbstractModelController
{
    #region CONSTRUCTOR

    /**
     * @param IProfileForm $profileForm
     * @param ITwoFactorForm $twoFactorForm
     * @param IUpdatePasswordForm $updatePasswordForm
     * @param IUserConfigurationForm $userConfigurationForm
     * @param IUserConfigurationFormRequest $formRequest
     *
     * @return void
     */
    public function __construct(
        IProfileForm $profileForm,
        ITwoFactorForm $twoFactorForm,
        IUpdatePasswordForm $updatePasswordForm,
        IUserConfigurationForm $userConfigurationForm,
        IUserConfigurationFormRequest $formRequest
    )
    {
        $this->formRequest = $formRequest;
        $this->profileForm = $profileForm;
        $this->twoFactorForm = $twoFactorForm;
        $this->updatePasswordForm = $updatePasswordForm;
        $this->userConfigurationForm = $userConfigurationForm;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var IProfileForm
     */
    protected readonly IProfileForm $profileForm;
    /**
     * @var ITwoFactorForm
     */
    protected readonly ITwoFactorForm $twoFactorForm;
    /**
     * @var IUpdatePasswordForm
     */
    protected readonly IUpdatePasswordForm $updatePasswordForm;
    /**
     * @var IUserConfigurationForm
     */
    protected readonly IUserConfigurationForm $userConfigurationForm;
    /**
     * @var IUserConfigurationFormRequest
     */
    protected readonly IUserConfigurationFormRequest $formRequest;

    #endregion

    #region PUBLIC METHODS

    /**
     * @return JsonResponse|Response
     */
    public function index(Request $request): JsonResponse|Response
    {
        $profileForm = $this->profileForm->get(
            action: route('user-profile-information.update'),
            method: MethodEnum::PUT,
            submit: trans('ui.update'),
        );

        $twoFactorForm = $this->twoFactorForm->get(
            action: route('two-factor.confirm'),
            method: MethodEnum::POST,
            submit: trans('ui.confirm'),
        );

        $updatePasswordForm = $this->updatePasswordForm->get(
            action: route('user-password.update'),
            method: MethodEnum::PUT,
            submit: trans('ui.update'),
        );

        $userConfigurationForm = $this->userConfigurationForm->get(
            action: route('user-configuration.store'),
            method: MethodEnum::PUT,
            submit: trans('ui.save'),
        );

        return Narsil::render('users/settings', [
            'labels'                => $this->getLabels(),
            'profileForm'           => $profileForm,
            'twoFactorForm'         => $twoFactorForm,
            'updatePasswordForm'    => $updatePasswordForm,
            'userConfigurationForm' => $userConfigurationForm,
        ]);
    }

    /**
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $attributes = $this->getAttributes($this->formRequest->rules());

        if ($user = Auth::user())
        {
            $configuration = UserConfiguration::query()
                ->firstWhere([
                    UserConfiguration::USER_ID => $user->{User::ID},
                ]);

            $configuration?->update($attributes);
        }

        if ($locale = Arr::get($attributes, UserConfiguration::LOCALE))
        {
            Session::put(LocaleMiddleware::LOCALE, $locale);
        }

        return back();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<string,string>
     */
    protected function getLabels(): array
    {
        return [
            'account'                         => trans('ui.account'),
            'personalization'                 => trans('ui.personalization'),
            'security'                        => trans('ui.security'),
            'sessions'                        => trans('ui.sessions'),
            'sign_out_current_description'    => trans('sessions.sign_out_current_description'),
            'sign_out_current'                => trans('sessions.sign_out_current'),
            'sign_out_elsewhere_description'  => trans('sessions.sign_out_elsewhere_description'),
            'sign_out_elsewhere'              => trans('sessions.sign_out_elsewhere'),
            'sign_out_everywhere_description' => trans('sessions.sign_out_everywhere_description'),
            'sign_out_everywhere'             => trans('sessions.sign_out_everywhere'),
        ];
    }

    #endregion
}
