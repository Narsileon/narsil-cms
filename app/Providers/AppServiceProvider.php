<?php

namespace App\Providers;

#region USE

use App\Http\Forms\Fortify\ConfirmPasswordForm;
use App\Http\Forms\Fortify\ForgotPasswordForm;
use App\Http\Forms\Fortify\LoginForm;
use App\Http\Forms\Fortify\RegisterForm;
use App\Http\Forms\Fortify\ResetPasswordForm;
use App\Http\Forms\Fortify\TwoFactorChallengeForm;
use App\Http\Forms\Resources\SiteForm;
use App\Http\Forms\Resources\SiteGroupForm;
use App\Http\Requests\Resources\SiteFormRequest;
use App\Http\Requests\Resources\SiteGroupFormRequest;
use App\Interfaces\FormRequests\Resources\ISiteFormRequest;
use App\Interfaces\FormRequests\Resources\ISiteGroupFormRequest;
use App\Interfaces\Forms\Fortify\IConfirmPasswordForm;
use App\Interfaces\Forms\Fortify\IForgotPasswordForm;
use App\Interfaces\Forms\Fortify\ILoginForm;
use App\Interfaces\Forms\Fortify\IRegisterForm;
use App\Interfaces\Forms\Fortify\IResetPasswordForm;
use App\Interfaces\Forms\Fortify\ITwoFactorChallengeForm;
use App\Interfaces\Forms\Resources\ISiteForm;
use App\Interfaces\Forms\Resources\ISiteGroupForm;
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
        $this->app->bind(ISiteFormRequest::class, SiteFormRequest::class);
        $this->app->bind(ISiteGroupFormRequest::class, SiteGroupFormRequest::class);
    }

    /**
     * @return void
     */
    private function bindForms(): void
    {
        $this->app->bind(ILoginForm::class, LoginForm::class);
        $this->app->bind(IConfirmPasswordForm::class, ConfirmPasswordForm::class);
        $this->app->bind(IForgotPasswordForm::class, ForgotPasswordForm::class);
        $this->app->bind(IRegisterForm::class, RegisterForm::class);
        $this->app->bind(IResetPasswordForm::class, ResetPasswordForm::class);
        $this->app->bind(ISiteForm::class, SiteForm::class);
        $this->app->bind(ISiteGroupForm::class, SiteGroupForm::class);
        $this->app->bind(ITwoFactorChallengeForm::class, TwoFactorChallengeForm::class);
    }

    #endregion
}
