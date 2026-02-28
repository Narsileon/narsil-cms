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

    \Narsil\Cms\Models\Collections\BlockElement::class => \Narsil\Cms\Observers\BlockElementObserver::class,
    \Narsil\Cms\Models\Collections\Template::class => \Narsil\Cms\Observers\TemplateObserver::class,
    \Narsil\Cms\Models\Collections\TemplateTabElement::class => \Narsil\Cms\Observers\TemplateTabElementObserver::class,
    \Narsil\Cms\Models\Hosts\HostLocale::class => \Narsil\Cms\Observers\HostLocaleObserver::class,
    \Narsil\Cms\Models\Sites\SitePage::class => \Narsil\Cms\Observers\SitePageObserver::class,
    \Narsil\Cms\Models\Sites\SitePageEntity::class => \Narsil\Cms\Observers\SitePageEntityObserver::class,
];
