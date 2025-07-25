<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Support\ServiceProvider;
use Narsil\Contracts\FormRequests\Fortify\CreateNewUserFormRequest as CreateNewUserFormRequestContract;
use Narsil\Contracts\FormRequests\Fortify\ResetUserPasswordFormRequest as ResetUserPasswordFormRequestContract;
use Narsil\Contracts\FormRequests\Fortify\UpdateUserPasswordFormRequest as UpdateUserPasswordFormRequestContract;
use Narsil\Contracts\FormRequests\Fortify\UpdateUserProfileInformationFormRequest as UpdateUserProfileInformationFormRequestContract;
use Narsil\Contracts\FormRequests\Resources\FieldFormRequest as FieldFormRequestContract;
use Narsil\Contracts\FormRequests\Resources\SiteFormRequest as SiteFormRequestContract;
use Narsil\Contracts\FormRequests\Resources\SiteGroupFormRequest as SiteGroupFormRequestContract;
use Narsil\Contracts\FormRequests\Resources\UserFormRequest as UserFormRequestContract;
use Narsil\Contracts\FormRequests\Users\UserConfigurationFormRequest as UserConfigurationFormRequestContract;
use Narsil\Http\Requests\Fortify\CreateNewUserFormRequest;
use Narsil\Http\Requests\Fortify\ResetUserPasswordFormRequest;
use Narsil\Http\Requests\Fortify\UpdateUserPasswordFormRequest;
use Narsil\Http\Requests\Fortify\UpdateUserProfileInformationFormRequest;
use Narsil\Http\Requests\Resources\FieldFormRequest;
use Narsil\Http\Requests\Resources\SiteFormRequest;
use Narsil\Http\Requests\Resources\SiteGroupFormRequest;
use Narsil\Http\Requests\Resources\UserFormRequest;
use Narsil\Http\Requests\Users\UserConfigurationFormRequest;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormRequestServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $this->app->singleton(CreateNewUserFormRequestContract::class, CreateNewUserFormRequest::class);
        $this->app->singleton(FieldFormRequestContract::class, FieldFormRequest::class);
        $this->app->singleton(ResetUserPasswordFormRequestContract::class, ResetUserPasswordFormRequest::class);
        $this->app->singleton(SiteFormRequestContract::class, SiteFormRequest::class);
        $this->app->singleton(SiteGroupFormRequestContract::class, SiteGroupFormRequest::class);
        $this->app->singleton(UpdateUserPasswordFormRequestContract::class, UpdateUserPasswordFormRequest::class);
        $this->app->singleton(UpdateUserProfileInformationFormRequestContract::class, UpdateUserProfileInformationFormRequest::class);
        $this->app->singleton(UserConfigurationFormRequestContract::class, UserConfigurationFormRequest::class);
        $this->app->singleton(UserFormRequestContract::class, UserFormRequest::class);
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
