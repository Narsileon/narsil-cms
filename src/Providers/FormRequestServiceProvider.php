<?php

namespace Narsil\Providers;

#region USE

use Illuminate\Support\ServiceProvider;
use Narsil\Contracts\FormRequests\Fortify\CreateNewUserFormRequest as CreateNewUserFormRequestContract;
use Narsil\Contracts\FormRequests\Fortify\ResetUserPasswordFormRequest as ResetUserPasswordFormRequestContract;
use Narsil\Contracts\FormRequests\Fortify\UpdateUserPasswordFormRequest as UpdateUserPasswordFormRequestContract;
use Narsil\Contracts\FormRequests\Fortify\UpdateUserProfileInformationFormRequest as UpdateUserProfileInformationFormRequestContract;
use Narsil\Contracts\FormRequests\Resources\FieldFormRequest as FieldFormRequestContract;
use Narsil\Contracts\FormRequests\Resources\FieldSetFormRequest as FieldSetFormRequestContract;
use Narsil\Contracts\FormRequests\Resources\SiteFormRequest as SiteFormRequestContract;
use Narsil\Contracts\FormRequests\Resources\SiteGroupFormRequest as SiteGroupFormRequestContract;
use Narsil\Contracts\FormRequests\Resources\UserFormRequest as UserFormRequestContract;
use Narsil\Contracts\FormRequests\Users\UserConfigurationFormRequest as UserConfigurationFormRequestContract;
use Narsil\Http\Requests\Fortify\CreateNewUserFormRequest;
use Narsil\Http\Requests\Fortify\ResetUserPasswordFormRequest;
use Narsil\Http\Requests\Fortify\UpdateUserPasswordFormRequest;
use Narsil\Http\Requests\Fortify\UpdateUserProfileInformationFormRequest;
use Narsil\Http\Requests\Resources\FieldFormRequest;
use Narsil\Http\Requests\Resources\FieldSetFormRequest;
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
        $map = $this->map();

        foreach ($map as $abstract => $concrete)
        {
            $this->app->singleton($abstract, $concrete);
            $this->app->tag($abstract, ['form-requests']);
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
            CreateNewUserFormRequestContract::class => CreateNewUserFormRequest::class,
            FieldFormRequestContract::class => FieldFormRequest::class,
            FieldSetFormRequestContract::class => FieldSetFormRequest::class,
            ResetUserPasswordFormRequestContract::class => ResetUserPasswordFormRequest::class,
            SiteFormRequestContract::class => SiteFormRequest::class,
            SiteGroupFormRequestContract::class => SiteGroupFormRequest::class,
            UpdateUserPasswordFormRequestContract::class => UpdateUserPasswordFormRequest::class,
            UpdateUserProfileInformationFormRequestContract::class => UpdateUserProfileInformationFormRequest::class,
            UserConfigurationFormRequestContract::class => UserConfigurationFormRequest::class,
            UserFormRequestContract::class => UserFormRequest::class,
        ];
    }

    #endregion
}
