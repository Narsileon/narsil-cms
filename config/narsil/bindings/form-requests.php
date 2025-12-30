<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Narsil - Form Request Bindings
    |--------------------------------------------------------------------------
    |
    | Mapping between form request contracts and their concrete implementations.
    |
    */

    \Narsil\Contracts\FormRequests\BlockFormRequest::class => \Narsil\Implementations\Requests\BlockFormRequest::class,
    \Narsil\Contracts\FormRequests\ConfigurationFormRequest::class => \Narsil\Implementations\Requests\ConfigurationFormRequest::class,
    \Narsil\Contracts\FormRequests\EntityDataFormRequest::class => \Narsil\Implementations\Requests\EntityDataFormRequest::class,
    \Narsil\Contracts\FormRequests\EntityFormRequest::class => \Narsil\Implementations\Requests\EntityFormRequest::class,
    \Narsil\Contracts\FormRequests\FieldFormRequest::class => \Narsil\Implementations\Requests\FieldFormRequest::class,
    \Narsil\Contracts\FormRequests\FieldsetFormRequest::class => \Narsil\Implementations\Requests\FieldsetFormRequest::class,
    \Narsil\Contracts\FormRequests\FooterFormRequest::class => \Narsil\Implementations\Requests\FooterFormRequest::class,
    \Narsil\Contracts\FormRequests\FormFormRequest::class => \Narsil\Implementations\Requests\FormFormRequest::class,
    \Narsil\Contracts\FormRequests\HeaderFormRequest::class => \Narsil\Implementations\Requests\HeaderFormRequest::class,
    \Narsil\Contracts\FormRequests\HostFormRequest::class => \Narsil\Implementations\Requests\HostFormRequest::class,
    \Narsil\Contracts\FormRequests\InputFormRequest::class => \Narsil\Implementations\Requests\InputFormRequest::class,
    \Narsil\Contracts\FormRequests\PermissionFormRequest::class => \Narsil\Implementations\Requests\PermissionFormRequest::class,
    \Narsil\Contracts\FormRequests\RoleFormRequest::class => \Narsil\Implementations\Requests\RoleFormRequest::class,
    \Narsil\Contracts\FormRequests\SitePageFormRequest::class => \Narsil\Implementations\Requests\SitePageFormRequest::class,
    \Narsil\Contracts\FormRequests\TemplateFormRequest::class => \Narsil\Implementations\Requests\TemplateFormRequest::class,
    \Narsil\Contracts\FormRequests\UserConfigurationFormRequest::class => \Narsil\Implementations\Requests\UserConfigurationFormRequest::class,
    \Narsil\Contracts\FormRequests\UserFormRequest::class => \Narsil\Implementations\Requests\UserFormRequest::class,

    /*
    |--------------------------------------------------------------------------
    | Fortify - Form Request Bindings
    |--------------------------------------------------------------------------
    |
    | Mapping between form request contracts and their concrete implementations.
    |
    */

    \Narsil\Contracts\FormRequests\Fortify\CreateNewUserFormRequest::class => \Narsil\Implementations\Requests\Fortify\CreateNewUserFormRequest::class,
    \Narsil\Contracts\FormRequests\Fortify\ResetUserPasswordFormRequest::class => \Narsil\Implementations\Requests\Fortify\ResetUserPasswordFormRequest::class,
    \Narsil\Contracts\FormRequests\Fortify\UpdateUserPasswordFormRequest::class => \Narsil\Implementations\Requests\Fortify\UpdateUserPasswordFormRequest::class,
    \Narsil\Contracts\FormRequests\Fortify\UpdateUserProfileInformationFormRequest::class => \Narsil\Implementations\Requests\Fortify\UpdateUserProfileInformationFormRequest::class,
];
