<?php

namespace Narsil\Providers;

#region USE

use Narsil\Contracts\Forms\Fortify\ConfirmPasswordForm as ConfirmPasswordFormContract;
use Narsil\Contracts\Forms\Fortify\ForgotPasswordForm as ForgotPasswordFormContract;
use Narsil\Contracts\Forms\Fortify\LoginForm as LoginFormContract;
use Narsil\Contracts\Forms\Fortify\ProfileForm as ProfileFormContract;
use Narsil\Contracts\Forms\Fortify\RegisterForm as RegisterFormContract;
use Narsil\Contracts\Forms\Fortify\ResetPasswordForm as ResetPasswordFormContract;
use Narsil\Contracts\Forms\Fortify\TwoFactorChallengeForm as TwoFactorChallengeFormContract;
use Narsil\Contracts\Forms\Fortify\TwoFactorForm as TwoFactorFormContract;
use Narsil\Contracts\Forms\Fortify\UpdatePasswordForm as UpdatePasswordFormContract;
use Narsil\Contracts\Forms\Resources\SiteForm as SiteFormContract;
use Narsil\Contracts\Forms\Resources\SiteGroupForm as SiteGroupFormContract;
use Narsil\Contracts\Forms\Resources\UserForm as UserFormContract;
use Narsil\Contracts\Forms\Users\UserConfigurationForm as UserConfigurationFormContract;
use Narsil\Forms\Fortify\ConfirmPasswordForm;
use Narsil\Forms\Fortify\ForgotPasswordForm;
use Narsil\Forms\Fortify\LoginForm;
use Narsil\Forms\Fortify\ProfileForm;
use Narsil\Forms\Fortify\RegisterForm;
use Narsil\Forms\Fortify\ResetPasswordForm;
use Narsil\Forms\Fortify\TwoFactorChallengeForm;
use Narsil\Forms\Fortify\TwoFactorForm;
use Narsil\Forms\Fortify\UpdatePasswordForm;
use Narsil\Forms\Resources\SiteForm;
use Narsil\Forms\Resources\SiteGroupForm;
use Narsil\Forms\Resources\UserForm;
use Narsil\Forms\Users\UserConfigurationForm;
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
