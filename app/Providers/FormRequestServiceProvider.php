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
class FormRequestServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function register(): void
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
     * {@inheritDoc}
     */
    public function boot(): void
    {
        //
    }

    #endregion
}
