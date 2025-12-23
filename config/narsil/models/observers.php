<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Model Observers
    |--------------------------------------------------------------------------
    |
    | Mapping between model classes and their obervers.
    |
    */

    \Narsil\Models\Elements\Template::class => \Narsil\Observers\TemplateObserver::class,
    \Narsil\Models\Entities\Entity::class => \Narsil\Observers\EntityObserver::class,
    \Narsil\Models\Entities\EntityBlockField::class => \Narsil\Observers\EntityBlockFieldObserver::class,
    \Narsil\Models\Hosts\Host::class => \Narsil\Observers\HostObserver::class,
    \Narsil\Models\Hosts\HostLocale::class => \Narsil\Observers\HostLocaleObserver::class,
    \Narsil\Models\Sites\Site::class => \Narsil\Observers\SiteObserver::class,
    \Narsil\Models\Sites\SitePage::class => \Narsil\Observers\SitePageObserver::class,
    \Narsil\Models\User::class => \Narsil\Observers\UserObserver::class,
];
