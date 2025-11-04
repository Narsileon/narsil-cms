<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Model Policies
    |--------------------------------------------------------------------------
    |
    | Mapping between models and their policies.
    |
    */

    \Narsil\Models\Elements\Block::class => \Narsil\Policies\BlockPolicy::class,
    \Narsil\Models\Elements\Field::class => \Narsil\Policies\FieldPolicy::class,
    \Narsil\Models\Elements\Template::class => \Narsil\Policies\TemplatePolicy::class,
    \Narsil\Models\Entities\Entity::class => \Narsil\Policies\EntityPolicy::class,
    \Narsil\Models\Hosts\Host::class => \Narsil\Policies\HostPolicy::class,
    \Narsil\Models\Policies\Permission::class => \Narsil\Policies\PermissionPolicy::class,
    \Narsil\Models\Policies\Role::class => \Narsil\Policies\RolePolicy::class,
    \Narsil\Models\Sites\Site::class => \Narsil\Policies\SitePolicy::class,
    \Narsil\Models\Sites\SitePage::class => \Narsil\Policies\SitePagePolicy::class,
    \Narsil\Models\User::class => \Narsil\Policies\UserPolicy::class,
];
