<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Narsil - Form Bindings
    |--------------------------------------------------------------------------
    |
    | Mapping between form contracts and their concrete implementations.
    |
    */

    \Narsil\Contracts\Forms\BlockElementForm::class => \Narsil\Implementations\Forms\BlockElementForm::class,
    \Narsil\Contracts\Forms\BlockForm::class => \Narsil\Implementations\Forms\BlockForm::class,
    \Narsil\Contracts\Forms\ConditionForm::class => \Narsil\Implementations\Forms\ConditionForm::class,
    \Narsil\Contracts\Forms\ConfigurationForm::class => \Narsil\Implementations\Forms\ConfigurationForm::class,
    \Narsil\Contracts\Forms\EntityForm::class => \Narsil\Implementations\Forms\EntityForm::class,
    \Narsil\Contracts\Forms\FieldForm::class => \Narsil\Implementations\Forms\FieldForm::class,
    \Narsil\Contracts\Forms\FieldsetElementForm::class => \Narsil\Implementations\Forms\FieldsetElementForm::class,
    \Narsil\Contracts\Forms\FieldsetForm::class => \Narsil\Implementations\Forms\FieldsetForm::class,
    \Narsil\Contracts\Forms\FooterForm::class => \Narsil\Implementations\Forms\FooterForm::class,
    \Narsil\Contracts\Forms\FormForm::class => \Narsil\Implementations\Forms\FormForm::class,
    \Narsil\Contracts\Forms\FormTabForm::class => \Narsil\Implementations\Forms\FormTabForm::class,
    \Narsil\Contracts\Forms\HeaderForm::class => \Narsil\Implementations\Forms\HeaderForm::class,
    \Narsil\Contracts\Forms\HostForm::class => \Narsil\Implementations\Forms\HostForm::class,
    \Narsil\Contracts\Forms\HostLocaleForm::class => \Narsil\Implementations\Forms\HostLocaleForm::class,
    \Narsil\Contracts\Forms\InputForm::class => \Narsil\Implementations\Forms\InputForm::class,
    \Narsil\Contracts\Forms\PermissionForm::class => \Narsil\Implementations\Forms\PermissionForm::class,
    \Narsil\Contracts\Forms\PublishForm::class => \Narsil\Implementations\Forms\PublishForm::class,
    \Narsil\Contracts\Forms\RoleForm::class => \Narsil\Implementations\Forms\RoleForm::class,
    \Narsil\Contracts\Forms\SiteForm::class => \Narsil\Implementations\Forms\SiteForm::class,
    \Narsil\Contracts\Forms\SitePageForm::class => \Narsil\Implementations\Forms\SitePageForm::class,
    \Narsil\Contracts\Forms\TemplateForm::class => \Narsil\Implementations\Forms\TemplateForm::class,
    \Narsil\Contracts\Forms\TemplateTabForm::class => \Narsil\Implementations\Forms\TemplateTabForm::class,
    \Narsil\Contracts\Forms\UserConfigurationForm::class => \Narsil\Implementations\Forms\UserConfigurationForm::class,
    \Narsil\Contracts\Forms\UserForm::class => \Narsil\Implementations\Forms\UserForm::class,

    /*
    |--------------------------------------------------------------------------
    | Fortify - Form Bindings
    |--------------------------------------------------------------------------
    |
    | Mapping between form contracts and their concrete implementations.
    |
    */

    \Narsil\Contracts\Forms\Fortify\ConfirmPasswordForm::class => \Narsil\Implementations\Forms\Fortify\ConfirmPasswordForm::class,
    \Narsil\Contracts\Forms\Fortify\ForgotPasswordForm::class => \Narsil\Implementations\Forms\Fortify\ForgotPasswordForm::class,
    \Narsil\Contracts\Forms\Fortify\LoginForm::class => \Narsil\Implementations\Forms\Fortify\LoginForm::class,
    \Narsil\Contracts\Forms\Fortify\ProfileForm::class => \Narsil\Implementations\Forms\Fortify\ProfileForm::class,
    \Narsil\Contracts\Forms\Fortify\RegisterForm::class => \Narsil\Implementations\Forms\Fortify\RegisterForm::class,
    \Narsil\Contracts\Forms\Fortify\ResetPasswordForm::class => \Narsil\Implementations\Forms\Fortify\ResetPasswordForm::class,
    \Narsil\Contracts\Forms\Fortify\TwoFactorChallengeForm::class => \Narsil\Implementations\Forms\Fortify\TwoFactorChallengeForm::class,
    \Narsil\Contracts\Forms\Fortify\TwoFactorForm::class => \Narsil\Implementations\Forms\Fortify\TwoFactorForm::class,
    \Narsil\Contracts\Forms\Fortify\UpdatePasswordForm::class => \Narsil\Implementations\Forms\Fortify\UpdatePasswordForm::class,
];
