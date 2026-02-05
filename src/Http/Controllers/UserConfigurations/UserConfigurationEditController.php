<?php

namespace Narsil\Cms\Http\Controllers\UserConfigurations;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Cms\Contracts\Forms\Fortify\ProfileForm;
use Narsil\Cms\Contracts\Forms\Fortify\TwoFactorForm;
use Narsil\Cms\Contracts\Forms\Fortify\UpdatePasswordForm;
use Narsil\Cms\Contracts\Forms\UserConfigurationForm;
use Narsil\Cms\Http\Controllers\RenderController;
use Narsil\Cms\Models\Users\UserConfiguration;
use Narsil\Cms\Services\ModelService;
use Narsil\Cms\Support\TranslationsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserConfigurationEditController extends RenderController
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

        return $this->render('narsil/cms::users/settings', [
            'profileForm' => $profileForm,
            'twoFactorForm' => $twoFactorForm,
            'updatePasswordForm' => $updatePasswordForm,
            'userConfigurationForm' => $userConfigurationForm,
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return ModelService::getModelLabel(UserConfiguration::class);
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return ModelService::getModelLabel(UserConfiguration::class);
    }

    #endregion
}
