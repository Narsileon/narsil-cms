<?php

namespace Narsil\Cms\Providers;

#region USE

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Contracts\PasswordConfirmedResponse;
use Laravel\Fortify\Contracts\PasswordUpdateResponse;
use Laravel\Fortify\Contracts\ProfileInformationUpdatedResponse;
use Laravel\Fortify\Contracts\TwoFactorConfirmedResponse;
use Laravel\Fortify\Contracts\TwoFactorDisabledResponse;
use Laravel\Fortify\Fortify;
use Narsil\Base\Actions\CreateNewUser;
use Narsil\Base\Actions\ResetUserPassword;
use Narsil\Base\Actions\UpdateUserPassword;
use Narsil\Base\Actions\UpdateUserProfileInformation;
use Narsil\Cms\Http\Controllers\Fortify\ConfirmPasswordController;
use Narsil\Cms\Http\Controllers\Fortify\ForgotPasswordController;
use Narsil\Cms\Http\Controllers\Fortify\LoginController;
use Narsil\Cms\Http\Controllers\Fortify\RegisterController;
use Narsil\Cms\Http\Controllers\Fortify\ResetPasswordController;
use Narsil\Cms\Http\Controllers\Fortify\TwoFactorChallengeController;
use Narsil\Cms\Http\Controllers\Fortify\VerifyEmailController;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
final class FortifyServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * Boot any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->bootActions();
        $this->bootViews();

        RateLimiter::for('login', function (Request $request)
        {
            $throttleKey = Str::transliterate(
                Str::lower(
                    $request->input(Fortify::username())
                ) . '|' . $request->ip()
            );

            return Limit::perMinute(5)
                ->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request)
        {
            return Limit::perMinute(5)
                ->by($request->session()->get('login.id'));
        });
    }

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $this->registerLoginResponse();
        $this->registerLogoutResponse();
        $this->registerPasswordConfirmedResponse();
        $this->registerPasswordUpdatedResponse();
        $this->registerProfileInformationUpdatedResponse();
        $this->registerTwoFactorConfirmedResponse();
        $this->registerTwoFactorDisabledResponse();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return void
     */
    protected function bootActions(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
    }

    /**
     * @return void
     */
    protected function bootViews(): void
    {
        Fortify::confirmPasswordView(function ()
        {
            return app(ConfirmPasswordController::class)
                ->__invoke(request());
        });
        Fortify::loginView(function ()
        {
            return app(LoginController::class)
                ->__invoke(request());
        });
        Fortify::registerView(function ()
        {
            return app(RegisterController::class)
                ->__invoke(request());
        });
        Fortify::requestPasswordResetLinkView(function ()
        {
            return app(ForgotPasswordController::class)
                ->__invoke(request());
        });
        Fortify::resetPasswordView(function ()
        {
            return app(ResetPasswordController::class)
                ->__invoke(request());
        });
        Fortify::twoFactorChallengeView(function ()
        {
            return app(TwoFactorChallengeController::class)
                ->__invoke(request());
        });
        Fortify::verifyEmailView(function ()
        {
            return app(VerifyEmailController::class)
                ->__invoke(request());
        });
    }

    /**
     * @return void
     */
    protected function registerLoginResponse(): void
    {
        $this->app->instance(LoginResponse::class, new class implements LoginResponse
        {
            public function toResponse($request)
            {
                return redirect()
                    ->intended(route('dashboard'))
                    ->with('success', trans('narsil::toasts.success.logged_in'));
            }
        });
    }

    /**
     * @return void
     */
    protected function registerLogoutResponse(): void
    {
        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse
        {
            public function toResponse($request)
            {
                return redirect(route('login'))
                    ->with('success', trans('narsil::toasts.success.logged_out'));
            }
        });
    }

    /**
     * @return void
     */
    protected function registerPasswordConfirmedResponse(): void
    {
        $this->app->instance(PasswordConfirmedResponse::class, new class implements PasswordConfirmedResponse
        {
            public function toResponse($request)
            {
                return redirect()
                    ->intended(route('dashboard'))
                    ->with('success', trans('narsil::toasts.success_password.confirmed'));
            }
        });
    }

    /**
     * @return void
     */
    protected function registerPasswordUpdatedResponse(): void
    {
        $this->app->instance(PasswordUpdateResponse::class, new class implements PasswordUpdateResponse
        {
            public function toResponse($request)
            {
                return back()
                    ->with('success', trans('narsil::toasts.success.password_updated'));
            }
        });
    }

    /**
     * @return void
     */
    protected function registerProfileInformationUpdatedResponse(): void
    {
        $this->app->instance(ProfileInformationUpdatedResponse::class, new class implements ProfileInformationUpdatedResponse
        {
            public function toResponse($request)
            {
                return back()
                    ->with('success', trans('narsil::toasts.success.profile.updated'));
            }
        });
    }

    /**
     * @return void
     */
    protected function registerTwoFactorConfirmedResponse(): void
    {
        $this->app->instance(TwoFactorConfirmedResponse::class, new class implements TwoFactorConfirmedResponse
        {
            public function toResponse($request)
            {
                return back()
                    ->with('success', trans('narsil::toasts.success.two_factor_confirmed'));
            }
        });
    }

    /**
     * @return void
     */
    protected function registerTwoFactorDisabledResponse(): void
    {
        $this->app->instance(TwoFactorDisabledResponse::class, new class implements TwoFactorDisabledResponse
        {
            public function toResponse($request)
            {
                return back()
                    ->with('success', trans('narsil::toasts.success.two_factor_disabled'));
            }
        });
    }

    #endregion
}
