<?php

namespace Narsil\Http\Controllers\UserConfigurations;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\Fortify\ProfileForm;
use Narsil\Contracts\Forms\Fortify\TwoFactorForm;
use Narsil\Contracts\Forms\Fortify\UpdatePasswordForm;
use Narsil\Contracts\Forms\UserConfigurationForm;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Support\TranslationsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserConfigurationEditController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request): JsonResponse|Response
    {
        $profileForm = app(ProfileForm::class);
        $twoFactorForm = app(TwoFactorForm::class);
        $updatePasswordForm = app(UpdatePasswordForm::class);
        $userConfigurationForm = app(UserConfigurationForm::class);

        app(TranslationsBag::class)
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

    #endregion
}
