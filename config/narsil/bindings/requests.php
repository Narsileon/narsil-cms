<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Request Bindings
    |--------------------------------------------------------------------------
    |
    | Mapping between request contracts and their implementations.
    |
    */

    \Narsil\Cms\Contracts\Requests\AssetFormRequest::class => \Narsil\Cms\Implementations\Requests\AssetFormRequest::class,
    \Narsil\Cms\Contracts\Requests\BlockFormRequest::class => \Narsil\Cms\Implementations\Requests\BlockFormRequest::class,
    \Narsil\Cms\Contracts\Requests\ConfigurationFormRequest::class => \Narsil\Cms\Implementations\Requests\ConfigurationFormRequest::class,
    \Narsil\Cms\Contracts\Requests\EntityFormRequest::class => \Narsil\Cms\Implementations\Requests\EntityFormRequest::class,
    \Narsil\Cms\Contracts\Requests\FieldFormRequest::class => \Narsil\Cms\Implementations\Requests\FieldFormRequest::class,
    \Narsil\Cms\Contracts\Requests\FooterFormRequest::class => \Narsil\Cms\Implementations\Requests\FooterFormRequest::class,
    \Narsil\Cms\Contracts\Requests\HeaderFormRequest::class => \Narsil\Cms\Implementations\Requests\HeaderFormRequest::class,
    \Narsil\Cms\Contracts\Requests\HostFormRequest::class => \Narsil\Cms\Implementations\Requests\HostFormRequest::class,
    \Narsil\Cms\Contracts\Requests\PermissionFormRequest::class => \Narsil\Cms\Implementations\Requests\PermissionFormRequest::class,
    \Narsil\Cms\Contracts\Requests\RoleFormRequest::class => \Narsil\Cms\Implementations\Requests\RoleFormRequest::class,
    \Narsil\Cms\Contracts\Requests\SitePageFormRequest::class => \Narsil\Cms\Implementations\Requests\SitePageFormRequest::class,
    \Narsil\Cms\Contracts\Requests\TemplateFormRequest::class => \Narsil\Cms\Implementations\Requests\TemplateFormRequest::class,
    \Narsil\Cms\Contracts\Requests\UserConfigurationFormRequest::class => \Narsil\Cms\Implementations\Requests\UserConfigurationFormRequest::class,
    \Narsil\Cms\Contracts\Requests\UserFormRequest::class => \Narsil\Cms\Implementations\Requests\UserFormRequest::class,

    /*
    |--------------------------------------------------------------------------
    | Fortify
    |--------------------------------------------------------------------------
    |
    | Mapping between request contracts and their implementations.
    |
    */

    \Narsil\Cms\Contracts\Requests\Fortify\CreateNewUserFormRequest::class => \Narsil\Cms\Implementations\Requests\Fortify\CreateNewUserFormRequest::class,
    \Narsil\Cms\Contracts\Requests\Fortify\ResetUserPasswordFormRequest::class => \Narsil\Cms\Implementations\Requests\Fortify\ResetUserPasswordFormRequest::class,
    \Narsil\Cms\Contracts\Requests\Fortify\UpdateUserPasswordFormRequest::class => \Narsil\Cms\Implementations\Requests\Fortify\UpdateUserPasswordFormRequest::class,
    \Narsil\Cms\Contracts\Requests\Fortify\UpdateUserProfileInformationFormRequest::class => \Narsil\Cms\Implementations\Requests\Fortify\UpdateUserProfileInformationFormRequest::class,

    /*
    |--------------------------------------------------------------------------
    | UI
    |--------------------------------------------------------------------------
    |
    | Mapping between request contracts and their implementations.
    |
    */

    \Narsil\Cms\Contracts\Requests\Base\TanStackTableFormRequest::class => \Narsil\Base\Http\Requests\TanStackTableFormRequest::class,
];
