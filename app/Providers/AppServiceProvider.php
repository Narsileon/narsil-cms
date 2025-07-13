<?php

namespace App\Providers;

#region USE

use App\Http\Forms\ConfirmPasswordForm;
use App\Http\Forms\ForgotPasswordForm;
use App\Http\Forms\LoginForm;
use App\Http\Forms\RegisterForm;
use App\Http\Forms\ResetPasswordForm;
use App\Http\Forms\SiteForm;
use App\Http\Forms\SiteGroupForm;
use App\Http\Forms\TwoFactorChallengeForm;
use App\Http\Requests\Sites\SiteFormRequest;
use App\Http\Requests\Sites\SiteGroupFormRequest;
use App\Interfaces\FormRequests\ISiteFormRequest;
use App\Interfaces\FormRequests\ISiteGroupFormRequest;
use App\Interfaces\Forms\IConfirmPasswordForm;
use App\Interfaces\Forms\IForgotPasswordForm;
use App\Interfaces\Forms\ILoginForm;
use App\Interfaces\Forms\IRegisterForm;
use App\Interfaces\Forms\IResetPasswordForm;
use App\Interfaces\Forms\ISiteForm;
use App\Interfaces\Forms\ISiteGroupForm;
use App\Interfaces\Forms\ITwoFactorChallengeForm;
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
