<?php

namespace App\Providers;

#region USE

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
use App\Forms\Fortify\ConfirmPasswordForm;
use App\Forms\Fortify\ForgotPasswordForm;
use App\Forms\Fortify\LoginForm;
use App\Forms\Fortify\ProfileForm;
use App\Forms\Fortify\RegisterForm;
use App\Forms\Fortify\ResetPasswordForm;
use App\Forms\Fortify\TwoFactorChallengeForm;
use App\Forms\Fortify\TwoFactorForm;
use App\Forms\Fortify\UpdatePasswordForm;
use App\Forms\Resources\SiteForm;
use App\Forms\Resources\SiteGroupForm;
use App\Forms\Resources\UserForm;
use App\Forms\Users\UserConfigurationForm;
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
     * {@inheritDoc}
     */
    public function register(): void
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

    /**
     * {@inheritDoc}
     */
    public function boot(): void
    {
        //
    }

    #endregion
}
