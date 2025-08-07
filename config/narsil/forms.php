<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Form Implementations
    |--------------------------------------------------------------------------
    |
    | This file defines a mapping between form contracts and their concrete implementations.
    |
    */

    \Narsil\Contracts\Forms\BlockForm::class => \Narsil\Implementations\Forms\BlockForm::class,
    \Narsil\Contracts\Forms\BlockElementForm::class => \Narsil\Implementations\Forms\BlockElementForm::class,
    \Narsil\Contracts\Forms\FieldForm::class => \Narsil\Implementations\Forms\FieldForm::class,
    \Narsil\Contracts\Forms\RoleForm::class => \Narsil\Implementations\Forms\RoleForm::class,
    \Narsil\Contracts\Forms\SiteForm::class => \Narsil\Implementations\Forms\SiteForm::class,
    \Narsil\Contracts\Forms\SiteGroupForm::class => \Narsil\Implementations\Forms\SiteGroupForm::class,
    \Narsil\Contracts\Forms\TemplateForm::class => \Narsil\Implementations\Forms\TemplateForm::class,
    \Narsil\Contracts\Forms\TemplateSectionForm::class => \Narsil\Implementations\Forms\TemplateSectionForm::class,
    \Narsil\Contracts\Forms\UserConfigurationForm::class => \Narsil\Implementations\Forms\UserConfigurationForm::class,
    \Narsil\Contracts\Forms\UserForm::class => \Narsil\Implementations\Forms\UserForm::class,

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
