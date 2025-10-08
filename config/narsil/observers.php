<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Model Observers
    |--------------------------------------------------------------------------
    |
    | This file defines a mapping between models and their obervers.
    |
    */

    \Narsil\Models\Elements\Template::class => \Narsil\Observers\TemplateObserver::class,
    \Narsil\Models\Entities\Entity::class => \Narsil\Observers\EntityObserver::class,
    \Narsil\Models\Entities\EntityBlock::class => \Narsil\Observers\EntityBlockObserver::class,
    \Narsil\Models\Hosts\HostLocale::class => \Narsil\Observers\HostLocaleObserver::class,
    \Narsil\Models\User::class => \Narsil\Observers\UserObserver::class,
];
