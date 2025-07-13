<?php

namespace App\Providers;

#region USE

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
use App\Http\Forms\UserConfigurationForm;
use App\Http\Requests\Fortify\CreateNewUserFormRequest;
use App\Http\Requests\Fortify\ResetUserPasswordFormRequest;
use App\Http\Requests\Fortify\UpdateUserPasswordFormRequest;
use App\Http\Requests\Fortify\UpdateUserProfileInformationFormRequest;
use App\Http\Requests\Resources\SiteFormRequest;
use App\Http\Requests\Resources\SiteGroupFormRequest;
use App\Http\Requests\UserConfigurationFormRequest;
use App\Interfaces\FormRequests\Fortify\ICreateNewUserFormRequest;
use App\Interfaces\FormRequests\Fortify\IResetUserPasswordFormRequest;
use App\Interfaces\FormRequests\Fortify\IUpdateUserPasswordFormRequest;
use App\Interfaces\FormRequests\Fortify\IUpdateUserProfileInformationFormRequest;
use App\Interfaces\FormRequests\IUserConfigurationFormRequest;
use App\Interfaces\FormRequests\Resources\ISiteFormRequest;
use App\Interfaces\FormRequests\Resources\ISiteGroupFormRequest;
use App\Interfaces\Forms\Fortify\IConfirmPasswordForm;
use App\Interfaces\Forms\Fortify\IForgotPasswordForm;
use App\Interfaces\Forms\Fortify\ILoginForm;
use App\Interfaces\Forms\Fortify\IProfileForm;
use App\Interfaces\Forms\Fortify\IRegisterForm;
use App\Interfaces\Forms\Fortify\IResetPasswordForm;
use App\Interfaces\Forms\Fortify\ITwoFactorChallengeForm;
use App\Interfaces\Forms\Fortify\ITwoFactorForm;
use App\Interfaces\Forms\Fortify\IUpdatePasswordForm;
use App\Interfaces\Forms\IUserConfigurationForm;
use App\Interfaces\Forms\Resources\ISiteForm;
use App\Interfaces\Forms\Resources\ISiteGroupForm;
use App\Support\LabelsBag;
use Illuminate\Support\ServiceProvider;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class AppServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(LabelsBag::class, function ()
        {
            return new LabelsBag();
        });

        $this->bindFormRequests();
        $this->bindForms();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
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
        $this->app->bind(ICreateNewUserFormRequest::class, CreateNewUserFormRequest::class);
        $this->app->bind(IResetUserPasswordFormRequest::class, ResetUserPasswordFormRequest::class);
        $this->app->bind(ISiteFormRequest::class, SiteFormRequest::class);
        $this->app->bind(ISiteGroupFormRequest::class, SiteGroupFormRequest::class);
        $this->app->bind(IUpdateUserPasswordFormRequest::class, UpdateUserPasswordFormRequest::class);
        $this->app->bind(IUpdateUserProfileInformationFormRequest::class, UpdateUserProfileInformationFormRequest::class);
        $this->app->bind(IUserConfigurationFormRequest::class, UserConfigurationFormRequest::class);
    }

    /**
     * @return void
     */
    private function bindForms(): void
    {
        $this->app->bind(IConfirmPasswordForm::class, ConfirmPasswordForm::class);
        $this->app->bind(IForgotPasswordForm::class, ForgotPasswordForm::class);
        $this->app->bind(ILoginForm::class, LoginForm::class);
        $this->app->bind(IProfileForm::class, ProfileForm::class);
        $this->app->bind(IRegisterForm::class, RegisterForm::class);
        $this->app->bind(IResetPasswordForm::class, ResetPasswordForm::class);
        $this->app->bind(ISiteForm::class, SiteForm::class);
        $this->app->bind(ISiteGroupForm::class, SiteGroupForm::class);
        $this->app->bind(ITwoFactorForm::class, TwoFactorForm::class);
        $this->app->bind(ITwoFactorChallengeForm::class, TwoFactorChallengeForm::class);
        $this->app->bind(IUpdatePasswordForm::class, UpdatePasswordForm::class);
        $this->app->bind(IUserConfigurationForm::class, UserConfigurationForm::class);
    }

    #endregion
}
