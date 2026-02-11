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

    \Narsil\Cms\Models\Collections\Block::class => \Narsil\Cms\Policies\BlockPolicy::class,
    \Narsil\Cms\Models\Collections\Field::class => \Narsil\Cms\Policies\FieldPolicy::class,
    \Narsil\Cms\Models\Collections\Template::class => \Narsil\Cms\Policies\TemplatePolicy::class,
    \Narsil\Cms\Models\Configuration::class => \Narsil\Cms\Policies\ConfigurationPolicy::class,
    \Narsil\Cms\Models\Entities\Entity::class => \Narsil\Cms\Policies\EntityPolicy::class,
    \Narsil\Cms\Models\Globals\Footer::class => \Narsil\Cms\Policies\FooterPolicy::class,
    \Narsil\Cms\Models\Globals\Header::class => \Narsil\Cms\Policies\HeaderPolicy::class,
    \Narsil\Cms\Models\Hosts\Host::class => \Narsil\Cms\Policies\HostPolicy::class,
    \Narsil\Cms\Models\Policies\Permission::class => \Narsil\Cms\Policies\PermissionPolicy::class,
    \Narsil\Cms\Models\Policies\Role::class => \Narsil\Cms\Policies\RolePolicy::class,
    \Narsil\Cms\Models\Sites\Site::class => \Narsil\Cms\Policies\SitePolicy::class,
    \Narsil\Cms\Models\Sites\SitePage::class => \Narsil\Cms\Policies\SitePagePolicy::class,
    \Narsil\Cms\Models\Storages\Asset::class => \Narsil\Cms\Policies\AssetPolicy::class,
    \Narsil\Cms\Models\User::class => \Narsil\Cms\Policies\UserPolicy::class,
];
