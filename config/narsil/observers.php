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
    \Narsil\Models\User::class => \Narsil\Observers\UserObserver::class,
];
