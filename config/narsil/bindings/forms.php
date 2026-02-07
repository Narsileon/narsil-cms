<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Form Bindings
    |--------------------------------------------------------------------------
    |
    | Mapping between form contracts and their implementations.
    |
    */

    \Narsil\Cms\Contracts\Forms\BlockElementForm::class => \Narsil\Cms\Implementations\Forms\BlockElementForm::class,
    \Narsil\Cms\Contracts\Forms\BlockForm::class => \Narsil\Cms\Implementations\Forms\BlockForm::class,
    \Narsil\Cms\Contracts\Forms\ConditionForm::class => \Narsil\Cms\Implementations\Forms\ConditionForm::class,
    \Narsil\Cms\Contracts\Forms\ConfigurationForm::class => \Narsil\Cms\Implementations\Forms\ConfigurationForm::class,
    \Narsil\Cms\Contracts\Forms\EntityForm::class => \Narsil\Cms\Implementations\Forms\EntityForm::class,
    \Narsil\Cms\Contracts\Forms\FieldForm::class => \Narsil\Cms\Implementations\Forms\FieldForm::class,
    \Narsil\Cms\Contracts\Forms\FooterForm::class => \Narsil\Cms\Implementations\Forms\FooterForm::class,
    \Narsil\Cms\Contracts\Forms\HeaderForm::class => \Narsil\Cms\Implementations\Forms\HeaderForm::class,
    \Narsil\Cms\Contracts\Forms\HostForm::class => \Narsil\Cms\Implementations\Forms\HostForm::class,
    \Narsil\Cms\Contracts\Forms\MediaForm::class => \Narsil\Cms\Implementations\Forms\MediaForm::class,
    \Narsil\Cms\Contracts\Forms\PermissionForm::class => \Narsil\Cms\Implementations\Forms\PermissionForm::class,
    \Narsil\Cms\Contracts\Forms\PublishForm::class => \Narsil\Cms\Implementations\Forms\PublishForm::class,
    \Narsil\Cms\Contracts\Forms\RoleForm::class => \Narsil\Cms\Implementations\Forms\RoleForm::class,
    \Narsil\Cms\Contracts\Forms\SiteForm::class => \Narsil\Cms\Implementations\Forms\SiteForm::class,
    \Narsil\Cms\Contracts\Forms\SitePageForm::class => \Narsil\Cms\Implementations\Forms\SitePageForm::class,
    \Narsil\Cms\Contracts\Forms\TemplateForm::class => \Narsil\Cms\Implementations\Forms\TemplateForm::class,
    \Narsil\Cms\Contracts\Forms\TemplateTabElementForm::class => \Narsil\Cms\Implementations\Forms\TemplateTabElementForm::class,
    \Narsil\Cms\Contracts\Forms\TemplateTabForm::class => \Narsil\Cms\Implementations\Forms\TemplateTabForm::class,
    \Narsil\Cms\Contracts\Forms\UserConfigurationForm::class => \Narsil\Cms\Implementations\Forms\UserConfigurationForm::class,
    \Narsil\Cms\Contracts\Forms\UserForm::class => \Narsil\Cms\Implementations\Forms\UserForm::class,

    /*
    |--------------------------------------------------------------------------
    | Fortify
    |--------------------------------------------------------------------------
    |
    | Mapping between form contracts and their implementations.
    |
    */

    \Narsil\Cms\Contracts\Forms\Fortify\ConfirmPasswordForm::class => \Narsil\Cms\Implementations\Forms\Fortify\ConfirmPasswordForm::class,
    \Narsil\Cms\Contracts\Forms\Fortify\ForgotPasswordForm::class => \Narsil\Cms\Implementations\Forms\Fortify\ForgotPasswordForm::class,
    \Narsil\Cms\Contracts\Forms\Fortify\LoginForm::class => \Narsil\Cms\Implementations\Forms\Fortify\LoginForm::class,
    \Narsil\Cms\Contracts\Forms\Fortify\ProfileForm::class => \Narsil\Cms\Implementations\Forms\Fortify\ProfileForm::class,
    \Narsil\Cms\Contracts\Forms\Fortify\RegisterForm::class => \Narsil\Cms\Implementations\Forms\Fortify\RegisterForm::class,
    \Narsil\Cms\Contracts\Forms\Fortify\ResetPasswordForm::class => \Narsil\Cms\Implementations\Forms\Fortify\ResetPasswordForm::class,
    \Narsil\Cms\Contracts\Forms\Fortify\TwoFactorChallengeForm::class => \Narsil\Cms\Implementations\Forms\Fortify\TwoFactorChallengeForm::class,
    \Narsil\Cms\Contracts\Forms\Fortify\TwoFactorForm::class => \Narsil\Cms\Implementations\Forms\Fortify\TwoFactorForm::class,
    \Narsil\Cms\Contracts\Forms\Fortify\UpdatePasswordForm::class => \Narsil\Cms\Implementations\Forms\Fortify\UpdatePasswordForm::class,
];
