<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Resource Bindings
    |--------------------------------------------------------------------------
    |
    | Mapping between models and their resources.
    |
    */

    \Narsil\Cms\Contracts\Resources\EntityResource::class => \Narsil\Cms\Implementations\Resources\EntityResource::class,
    \Narsil\Cms\Contracts\Resources\UserResource::class => \Narsil\Cms\Implementations\Resources\UserResource::class,
];
