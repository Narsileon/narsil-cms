<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Model Policies
    |--------------------------------------------------------------------------
    |
    | Mapping between model classes and their policies.
    |
    */

    \Narsil\Models\Configuration::class => \Narsil\Policies\ConfigurationPolicy::class,
    \Narsil\Models\Structures\Block::class => \Narsil\Policies\BlockPolicy::class,
    \Narsil\Models\Structures\Field::class => \Narsil\Policies\FieldPolicy::class,
    \Narsil\Models\Structures\Template::class => \Narsil\Policies\TemplatePolicy::class,
    \Narsil\Models\Entities\Entity::class => \Narsil\Policies\EntityPolicy::class,
    \Narsil\Models\Forms\Form::class => \Narsil\Policies\FormPolicy::class,
    \Narsil\Models\Forms\FormFieldset::class => \Narsil\Policies\FormFieldsetPolicy::class,
    \Narsil\Models\Forms\FormInput::class => \Narsil\Policies\FormInputPolicy::class,
    \Narsil\Models\Globals\Footer::class => \Narsil\Policies\FooterPolicy::class,
    \Narsil\Models\Globals\Header::class => \Narsil\Policies\HeaderPolicy::class,
    \Narsil\Models\Hosts\Host::class => \Narsil\Policies\HostPolicy::class,
    \Narsil\Models\Policies\Permission::class => \Narsil\Policies\PermissionPolicy::class,
    \Narsil\Models\Policies\Role::class => \Narsil\Policies\RolePolicy::class,
    \Narsil\Models\Sites\Site::class => \Narsil\Policies\SitePolicy::class,
    \Narsil\Models\Sites\SitePage::class => \Narsil\Policies\SitePagePolicy::class,
    \Narsil\Models\User::class => \Narsil\Policies\UserPolicy::class,
];
