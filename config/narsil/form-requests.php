<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Form Request Implementations
    |--------------------------------------------------------------------------
    |
    | This file defines a mapping between form request contracts and their concrete implementations.
    |
    */

    \Narsil\Contracts\FormRequests\BlockFormRequest::class => \Narsil\Http\Requests\BlockFormRequest::class,
    \Narsil\Contracts\FormRequests\EntityFormRequest::class => \Narsil\Http\Requests\EntityFormRequest::class,
    \Narsil\Contracts\FormRequests\FieldFormRequest::class => \Narsil\Http\Requests\FieldFormRequest::class,
    \Narsil\Contracts\FormRequests\RoleFormRequest::class => \Narsil\Http\Requests\RoleFormRequest::class,
    \Narsil\Contracts\FormRequests\SiteFormRequest::class => \Narsil\Http\Requests\SiteFormRequest::class,
    \Narsil\Contracts\FormRequests\TemplateFormRequest::class => \Narsil\Http\Requests\TemplateFormRequest::class,
    \Narsil\Contracts\FormRequests\UserConfigurationFormRequest::class => \Narsil\Http\Requests\UserConfigurationFormRequest::class,
    \Narsil\Contracts\FormRequests\UserFormRequest::class => \Narsil\Http\Requests\UserFormRequest::class,

    \Narsil\Contracts\FormRequests\Fortify\CreateNewUserFormRequest::class => \Narsil\Http\Requests\Fortify\CreateNewUserFormRequest::class,
    \Narsil\Contracts\FormRequests\Fortify\ResetUserPasswordFormRequest::class => \Narsil\Http\Requests\Fortify\ResetUserPasswordFormRequest::class,
    \Narsil\Contracts\FormRequests\Fortify\UpdateUserPasswordFormRequest::class => \Narsil\Http\Requests\Fortify\UpdateUserPasswordFormRequest::class,
    \Narsil\Contracts\FormRequests\Fortify\UpdateUserProfileInformationFormRequest::class => \Narsil\Http\Requests\Fortify\UpdateUserProfileInformationFormRequest::class,
];
