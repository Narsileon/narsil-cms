<?php

namespace App\Http\Controllers\Users;

#region USE

use App\Contracts\FormRequests\Users\UserConfigurationFormRequest;
use App\Contracts\Forms\Fortify\ProfileForm;
use App\Contracts\Forms\Fortify\TwoFactorForm;
use App\Contracts\Forms\Fortify\UpdatePasswordForm;
use App\Contracts\Forms\Users\UserConfigurationForm;
use App\Enums\Forms\MethodEnum;
use App\Http\Controllers\AbstractModelController;
use App\Http\Middleware\LocaleMiddleware;
use App\Models\User;
use App\Models\Users\UserConfiguration;
use App\Narsil;
use App\Support\LabelsBag;
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
     * @param ProfileForm $profileForm
     * @param TwoFactorForm $twoFactorForm
     * @param UpdatePasswordForm $updatePasswordForm
     * @param UserConfigurationForm $userConfigurationForm
     * @param UserConfigurationFormRequest $formRequest
     *
     * @return void
     */
    public function __construct(
        ProfileForm $profileForm,
        TwoFactorForm $twoFactorForm,
        UpdatePasswordForm $updatePasswordForm,
        UserConfigurationForm $userConfigurationForm,
        UserConfigurationFormRequest $formRequest
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
     * @var ProfileForm
     */
    protected readonly ProfileForm $profileForm;
    /**
     * @var TwoFactorForm
     */
    protected readonly TwoFactorForm $twoFactorForm;
    /**
     * @var UpdatePasswordForm
     */
    protected readonly UpdatePasswordForm $updatePasswordForm;
    /**
     * @var UserConfigurationForm
     */
    protected readonly UserConfigurationForm $userConfigurationForm;
    /**
     * @var UserConfigurationFormRequest
     */
    protected readonly UserConfigurationFormRequest $formRequest;

    #endregion

    #region PUBLIC METHODS

    /**
     * @return JsonResponse|Response
     */
    public function index(Request $request): JsonResponse|Response
    {
        $this->registerLabels();

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
     * @return void
     */
    protected function registerLabels(): void
    {
        app(LabelsBag::class)
            ->add('sessions.sign_out_current_description')
            ->add('sessions.sign_out_current')
            ->add('sessions.sign_out_elsewhere_description')
            ->add('sessions.sign_out_elsewhere')
            ->add('sessions.sign_out_everywhere_description')
            ->add('sessions.sign_out_everywhere')
            ->add('ui.account')
            ->add('ui.password')
            ->add('ui.personalization')
            ->add('ui.security')
            ->add('ui.sessions');
    }

    #endregion
}
