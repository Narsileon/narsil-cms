<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Response;
use Narsil\Contracts\FormRequests\UserConfigurationFormRequest;
use Narsil\Contracts\Forms\Fortify\ProfileForm;
use Narsil\Contracts\Forms\Fortify\TwoFactorForm;
use Narsil\Contracts\Forms\Fortify\UpdatePasswordForm;
use Narsil\Contracts\Forms\UserConfigurationForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Middleware\LocaleMiddleware;
use Narsil\Models\User;
use Narsil\Models\Users\UserConfiguration;
use Narsil\Support\LabelsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserConfigurationController extends AbstractController
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
            url: route('user-profile-information.update'),
            method: MethodEnum::PUT,
            submit: trans('narsil-cms::ui.update'),
        );

        $twoFactorForm = $this->twoFactorForm->get(
            url: route('two-factor.confirm'),
            method: MethodEnum::POST,
            submit: trans('narsil-cms::ui.confirm'),
        );

        $updatePasswordForm = $this->updatePasswordForm->get(
            url: route('user-password.update'),
            method: MethodEnum::PUT,
            submit: trans('narsil-cms::ui.update'),
        );

        $userConfigurationForm = $this->userConfigurationForm->get(
            url: route('user-configuration.store'),
            method: MethodEnum::PUT,
            submit: trans('narsil-cms::ui.save'),
        );

        return $this->render(
            component: 'narsil/cms::users/settings',
            title: trans('narsil-cms::ui.settings'),
            description: trans('narsil-cms::ui.settings'),
            props: [
                'profileForm'           => $profileForm,
                'twoFactorForm'         => $twoFactorForm,
                'updatePasswordForm'    => $updatePasswordForm,
                'userConfigurationForm' => $userConfigurationForm,
            ]
        );
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
            ->add('narsil-cms::sessions.sign_out_current_description')
            ->add('narsil-cms::sessions.sign_out_current')
            ->add('narsil-cms::sessions.sign_out_elsewhere_description')
            ->add('narsil-cms::sessions.sign_out_elsewhere')
            ->add('narsil-cms::sessions.sign_out_everywhere_description')
            ->add('narsil-cms::sessions.sign_out_everywhere')
            ->add('narsil-cms::ui.account')
            ->add('narsil-cms::ui.password')
            ->add('narsil-cms::ui.personalization')
            ->add('narsil-cms::ui.security')
            ->add('narsil-cms::ui.sessions');
    }

    #endregion
}
