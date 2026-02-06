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

    \Narsil\Cms\Contracts\FormRequests\BlockFormRequest::class => \Narsil\Cms\Implementations\Requests\BlockFormRequest::class,
    \Narsil\Cms\Contracts\FormRequests\ConfigurationFormRequest::class => \Narsil\Cms\Implementations\Requests\ConfigurationFormRequest::class,
    \Narsil\Cms\Contracts\FormRequests\EntityFormRequest::class => \Narsil\Cms\Implementations\Requests\EntityFormRequest::class,
    \Narsil\Cms\Contracts\FormRequests\FieldFormRequest::class => \Narsil\Cms\Implementations\Requests\FieldFormRequest::class,
    \Narsil\Cms\Contracts\FormRequests\FieldsetFormRequest::class => \Narsil\Cms\Implementations\Requests\FieldsetFormRequest::class,
    \Narsil\Cms\Contracts\FormRequests\FooterFormRequest::class => \Narsil\Cms\Implementations\Requests\FooterFormRequest::class,
    \Narsil\Cms\Contracts\FormRequests\FormFormRequest::class => \Narsil\Cms\Implementations\Requests\FormFormRequest::class,
    \Narsil\Cms\Contracts\FormRequests\FormSubmissionDataFormRequest::class => \Narsil\Cms\Implementations\Requests\FormSubmissionDataFormRequest::class,
    \Narsil\Cms\Contracts\FormRequests\FormSubmissionFormRequest::class => \Narsil\Cms\Implementations\Requests\FormSubmissionFormRequest::class,
    \Narsil\Cms\Contracts\FormRequests\HeaderFormRequest::class => \Narsil\Cms\Implementations\Requests\HeaderFormRequest::class,
    \Narsil\Cms\Contracts\FormRequests\HostFormRequest::class => \Narsil\Cms\Implementations\Requests\HostFormRequest::class,
    \Narsil\Cms\Contracts\FormRequests\InputFormRequest::class => \Narsil\Cms\Implementations\Requests\InputFormRequest::class,
    \Narsil\Cms\Contracts\FormRequests\MediaFormRequest::class => \Narsil\Cms\Implementations\Requests\MediaFormRequest::class,
    \Narsil\Cms\Contracts\FormRequests\PermissionFormRequest::class => \Narsil\Cms\Implementations\Requests\PermissionFormRequest::class,
    \Narsil\Cms\Contracts\FormRequests\RoleFormRequest::class => \Narsil\Cms\Implementations\Requests\RoleFormRequest::class,
    \Narsil\Cms\Contracts\FormRequests\SitePageFormRequest::class => \Narsil\Cms\Implementations\Requests\SitePageFormRequest::class,
    \Narsil\Cms\Contracts\FormRequests\TemplateFormRequest::class => \Narsil\Cms\Implementations\Requests\TemplateFormRequest::class,
    \Narsil\Cms\Contracts\FormRequests\UserConfigurationFormRequest::class => \Narsil\Cms\Implementations\Requests\UserConfigurationFormRequest::class,
    \Narsil\Cms\Contracts\FormRequests\UserFormRequest::class => \Narsil\Cms\Implementations\Requests\UserFormRequest::class,

    /*
    |--------------------------------------------------------------------------
    | Fortify - Form Request Bindings
    |--------------------------------------------------------------------------
    |
    | Mapping between form request contracts and their concrete implementations.
    |
    */

    \Narsil\Cms\Contracts\FormRequests\Fortify\CreateNewUserFormRequest::class => \Narsil\Cms\Implementations\Requests\Fortify\CreateNewUserFormRequest::class,
    \Narsil\Cms\Contracts\FormRequests\Fortify\ResetUserPasswordFormRequest::class => \Narsil\Cms\Implementations\Requests\Fortify\ResetUserPasswordFormRequest::class,
    \Narsil\Cms\Contracts\FormRequests\Fortify\UpdateUserPasswordFormRequest::class => \Narsil\Cms\Implementations\Requests\Fortify\UpdateUserPasswordFormRequest::class,
    \Narsil\Cms\Contracts\FormRequests\Fortify\UpdateUserProfileInformationFormRequest::class => \Narsil\Cms\Implementations\Requests\Fortify\UpdateUserProfileInformationFormRequest::class,
];
