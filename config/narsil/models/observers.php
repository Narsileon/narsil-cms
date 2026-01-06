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

    \Narsil\Models\Forms\FieldsetElement::class => \Narsil\Observers\FieldsetElementObserver::class,
    \Narsil\Models\Forms\FormTabElement::class => \Narsil\Observers\FormTabElementObserver::class,
    \Narsil\Models\Hosts\HostLocale::class => \Narsil\Observers\HostLocaleObserver::class,
    \Narsil\Models\Sites\Site::class => \Narsil\Observers\SiteObserver::class,
    \Narsil\Models\Sites\SitePage::class => \Narsil\Observers\SitePageObserver::class,
    \Narsil\Models\Sites\SitePageEntity::class => \Narsil\Observers\SitePageEntityObserver::class,
    \Narsil\Models\Structures\BlockElement::class => \Narsil\Observers\BlockElementObserver::class,
    \Narsil\Models\Structures\Template::class => \Narsil\Observers\TemplateObserver::class,
    \Narsil\Models\Structures\TemplateTabElement::class => \Narsil\Observers\TemplateTabElementObserver::class,
    \Narsil\Models\User::class => \Narsil\Observers\UserObserver::class,
];
