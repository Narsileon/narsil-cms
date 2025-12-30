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

    \Narsil\Models\Entities\Entity::class => \Narsil\Observers\EntityObserver::class,
    \Narsil\Models\Entities\EntityBlockField::class => \Narsil\Observers\EntityBlockFieldObserver::class,
    \Narsil\Models\Forms\FieldsetElement::class => \Narsil\Observers\FieldsetElementObserver::class,
    \Narsil\Models\Forms\FormPageElement::class => \Narsil\Observers\FormPageElementObserver::class,
    \Narsil\Models\Hosts\HostLocale::class => \Narsil\Observers\HostLocaleObserver::class,
    \Narsil\Models\Sites\Site::class => \Narsil\Observers\SiteObserver::class,
    \Narsil\Models\Sites\SitePage::class => \Narsil\Observers\SitePageObserver::class,
    \Narsil\Models\Structures\BlockElement::class => \Narsil\Observers\BlockElementObserver::class,
    \Narsil\Models\Structures\Template::class => \Narsil\Observers\TemplateObserver::class,
    \Narsil\Models\Structures\TemplateSectionElement::class => \Narsil\Observers\TemplateSectionElementObserver::class,
    \Narsil\Models\User::class => \Narsil\Observers\UserObserver::class,
];
