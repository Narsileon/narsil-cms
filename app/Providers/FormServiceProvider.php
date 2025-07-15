<?php

namespace App\Providers;

#region USE

use App\Contracts\FormRequests\Fortify\CreateNewUserFormRequest as CreateNewUserFormRequestContract;
use App\Contracts\FormRequests\Fortify\ResetUserPasswordFormRequest as ResetUserPasswordFormRequestContract;
use App\Contracts\FormRequests\Fortify\UpdateUserPasswordFormRequest as UpdateUserPasswordFormRequestContract;
use App\Contracts\FormRequests\Fortify\UpdateUserProfileInformationFormRequest as UpdateUserProfileInformationFormRequestContract;
use App\Contracts\FormRequests\Resources\SiteFormRequest as SiteFormRequestContract;
use App\Contracts\FormRequests\Resources\SiteGroupFormRequest as SiteGroupFormRequestContract;
use App\Contracts\FormRequests\Resources\UserFormRequest as UserFormRequestContract;
use App\Contracts\FormRequests\Users\UserConfigurationFormRequest as UserConfigurationFormRequestContract;
use App\Contracts\Forms\Fortify\ConfirmPasswordForm as ConfirmPasswordFormContract;
use App\Contracts\Forms\Fortify\ForgotPasswordForm as ForgotPasswordFormContract;
use App\Contracts\Forms\Fortify\LoginForm as LoginFormContract;
use App\Contracts\Forms\Fortify\ProfileForm as ProfileFormContract;
use App\Contracts\Forms\Fortify\RegisterForm as RegisterFormContract;
use App\Contracts\Forms\Fortify\ResetPasswordForm as ResetPasswordFormContract;
use App\Contracts\Forms\Fortify\TwoFactorChallengeForm as TwoFactorChallengeFormContract;
use App\Contracts\Forms\Fortify\TwoFactorForm as TwoFactorFormContract;
use App\Contracts\Forms\Fortify\UpdatePasswordForm as UpdatePasswordFormContract;
use App\Contracts\Forms\Resources\SiteForm as SiteFormContract;
use App\Contracts\Forms\Resources\SiteGroupForm as SiteGroupFormContract;
use App\Contracts\Forms\Resources\UserForm as UserFormContract;
use App\Contracts\Forms\Users\UserConfigurationForm as UserConfigurationFormContract;
use App\Http\Forms\Fortify\ConfirmPasswordForm;
use App\Http\Forms\Fortify\ForgotPasswordForm;
use App\Http\Forms\Fortify\LoginForm;
use App\Http\Forms\Fortify\ProfileForm;
use App\Http\Forms\Fortify\RegisterForm;
use App\Http\Forms\Fortify\ResetPasswordForm;
use App\Http\Forms\Fortify\TwoFactorChallengeForm;
use App\Http\Forms\Fortify\TwoFactorForm;
use App\Http\Forms\Fortify\UpdatePasswordForm;
use App\Http\Forms\Resources\SiteForm;
use App\Http\Forms\Resources\SiteGroupForm;
use App\Http\Forms\Resources\UserForm;
use App\Http\Forms\Users\UserConfigurationForm;
use App\Http\Requests\Fortify\CreateNewUserFormRequest;
use App\Http\Requests\Fortify\ResetUserPasswordFormRequest;
use App\Http\Requests\Fortify\UpdateUserPasswordFormRequest;
use App\Http\Requests\Fortify\UpdateUserProfileInformationFormRequest;
use App\Http\Requests\Resources\SiteFormRequest;
use App\Http\Requests\Resources\SiteGroupFormRequest;
use App\Http\Requests\Resources\UserFormRequest;
use App\Http\Requests\Users\UserConfigurationFormRequest;
use Illuminate\Support\ServiceProvider;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * {@inheritdoc}
     */
    public function register(): void
    {
        $this->bindFormRequests();
        $this->bindForms();
    }

    /**
     * {@inheritdoc}
     */
    public function boot(): void
    {
        //
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @return void
     */
    private function bindFormRequests(): void
    {
        $this->app->singleton(CreateNewUserFormRequestContract::class, CreateNewUserFormRequest::class);
        $this->app->singleton(ResetUserPasswordFormRequestContract::class, ResetUserPasswordFormRequest::class);
        $this->app->singleton(SiteFormRequestContract::class, SiteFormRequest::class);
        $this->app->singleton(SiteGroupFormRequestContract::class, SiteGroupFormRequest::class);
        $this->app->singleton(UpdateUserPasswordFormRequestContract::class, UpdateUserPasswordFormRequest::class);
        $this->app->singleton(UpdateUserProfileInformationFormRequestContract::class, UpdateUserProfileInformationFormRequest::class);
        $this->app->singleton(UserConfigurationFormRequestContract::class, UserConfigurationFormRequest::class);
        $this->app->singleton(UserFormRequestContract::class, UserFormRequest::class);
    }

    /**
     * @return void
     */
    private function bindForms(): void
    {
        $this->app->singleton(ConfirmPasswordFormContract::class, ConfirmPasswordForm::class);
        $this->app->singleton(ForgotPasswordFormContract::class, ForgotPasswordForm::class);
        $this->app->singleton(LoginFormContract::class, LoginForm::class);
        $this->app->singleton(ProfileFormContract::class, ProfileForm::class);
        $this->app->singleton(RegisterFormContract::class, RegisterForm::class);
        $this->app->singleton(ResetPasswordFormContract::class, ResetPasswordForm::class);
        $this->app->singleton(SiteFormContract::class, SiteForm::class);
        $this->app->singleton(SiteGroupFormContract::class, SiteGroupForm::class);
        $this->app->singleton(TwoFactorFormContract::class, TwoFactorForm::class);
        $this->app->singleton(TwoFactorChallengeFormContract::class, TwoFactorChallengeForm::class);
        $this->app->singleton(UpdatePasswordFormContract::class, UpdatePasswordForm::class);
        $this->app->singleton(UserConfigurationFormContract::class, UserConfigurationForm::class);
        $this->app->singleton(UserFormContract::class, UserForm::class);
    }

    #endregion
}
