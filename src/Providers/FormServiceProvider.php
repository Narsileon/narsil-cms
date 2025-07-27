<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Support\ServiceProvider;
use Narsil\Contracts\Forms\Fortify\ConfirmPasswordForm as ConfirmPasswordFormContract;
use Narsil\Contracts\Forms\Fortify\ForgotPasswordForm as ForgotPasswordFormContract;
use Narsil\Contracts\Forms\Fortify\LoginForm as LoginFormContract;
use Narsil\Contracts\Forms\Fortify\ProfileForm as ProfileFormContract;
use Narsil\Contracts\Forms\Fortify\RegisterForm as RegisterFormContract;
use Narsil\Contracts\Forms\Fortify\ResetPasswordForm as ResetPasswordFormContract;
use Narsil\Contracts\Forms\Fortify\TwoFactorChallengeForm as TwoFactorChallengeFormContract;
use Narsil\Contracts\Forms\Fortify\TwoFactorForm as TwoFactorFormContract;
use Narsil\Contracts\Forms\Fortify\UpdatePasswordForm as UpdatePasswordFormContract;
use Narsil\Contracts\Forms\Resources\FieldForm as FieldFormContract;
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
use Narsil\Forms\Resources\FieldForm;
use Narsil\Forms\Resources\SiteForm;
use Narsil\Forms\Resources\SiteGroupForm;
use Narsil\Forms\Resources\UserForm;
use Narsil\Forms\Users\UserConfigurationForm;

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
        $map = $this->map();

        foreach ($map as $abstract => $concrete)
        {
            $this->app->singleton($abstract, $concrete);
            $this->app->tag($abstract, ['forms']);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function boot(): void
    {
        //
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<string,string>
     */
    protected function map(): array
    {
        return [
            ConfirmPasswordFormContract::class => ConfirmPasswordForm::class,
            FieldFormContract::class => FieldForm::class,
            ForgotPasswordFormContract::class => ForgotPasswordForm::class,
            LoginFormContract::class => LoginForm::class,
            ProfileFormContract::class => ProfileForm::class,
            RegisterFormContract::class => RegisterForm::class,
            ResetPasswordFormContract::class => ResetPasswordForm::class,
            SiteFormContract::class => SiteForm::class,
            SiteGroupFormContract::class => SiteGroupForm::class,
            TwoFactorFormContract::class => TwoFactorForm::class,
            TwoFactorChallengeFormContract::class => TwoFactorChallengeForm::class,
            UpdatePasswordFormContract::class => UpdatePasswordForm::class,
            UserConfigurationFormContract::class => UserConfigurationForm::class,
            UserFormContract::class => UserForm::class,
        ];
    }

    #endregion
}
