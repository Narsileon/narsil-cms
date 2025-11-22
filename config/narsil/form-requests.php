<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Narsil - Form Request Implementations
    |--------------------------------------------------------------------------
    |
    | Mapping between form request contracts and their concrete implementations.
    |
    */

    \Narsil\Contracts\FormRequests\BlockFormRequest::class => \Narsil\Http\Requests\BlockFormRequest::class,
    \Narsil\Contracts\FormRequests\ConfigurationFormRequest::class => \Narsil\Http\Requests\ConfigurationFormRequest::class,
    \Narsil\Contracts\FormRequests\EntityFormRequest::class => \Narsil\Http\Requests\EntityFormRequest::class,
    \Narsil\Contracts\FormRequests\FieldFormRequest::class => \Narsil\Http\Requests\FieldFormRequest::class,
    \Narsil\Contracts\FormRequests\FooterFormRequest::class => \Narsil\Http\Requests\FooterFormRequest::class,
    \Narsil\Contracts\FormRequests\HeaderFormRequest::class => \Narsil\Http\Requests\HeaderFormRequest::class,
    \Narsil\Contracts\FormRequests\HostFormRequest::class => \Narsil\Http\Requests\HostFormRequest::class,
    \Narsil\Contracts\FormRequests\PermissionFormRequest::class => \Narsil\Http\Requests\PermissionFormRequest::class,
    \Narsil\Contracts\FormRequests\RoleFormRequest::class => \Narsil\Http\Requests\RoleFormRequest::class,
    \Narsil\Contracts\FormRequests\SitePageFormRequest::class => \Narsil\Http\Requests\SitePageFormRequest::class,
    \Narsil\Contracts\FormRequests\TemplateFormRequest::class => \Narsil\Http\Requests\TemplateFormRequest::class,
    \Narsil\Contracts\FormRequests\UserConfigurationFormRequest::class => \Narsil\Http\Requests\UserConfigurationFormRequest::class,
    \Narsil\Contracts\FormRequests\UserFormRequest::class => \Narsil\Http\Requests\UserFormRequest::class,

    /*
    |--------------------------------------------------------------------------
    | Fortify - Form Request Implementations
    |--------------------------------------------------------------------------
    |
    | Mapping between form request contracts and their concrete implementations.
    |
    */

    \Narsil\Contracts\FormRequests\Fortify\CreateNewUserFormRequest::class => \Narsil\Http\Requests\Fortify\CreateNewUserFormRequest::class,
    \Narsil\Contracts\FormRequests\Fortify\ResetUserPasswordFormRequest::class => \Narsil\Http\Requests\Fortify\ResetUserPasswordFormRequest::class,
    \Narsil\Contracts\FormRequests\Fortify\UpdateUserPasswordFormRequest::class => \Narsil\Http\Requests\Fortify\UpdateUserPasswordFormRequest::class,
    \Narsil\Contracts\FormRequests\Fortify\UpdateUserProfileInformationFormRequest::class => \Narsil\Http\Requests\Fortify\UpdateUserProfileInformationFormRequest::class,
];
