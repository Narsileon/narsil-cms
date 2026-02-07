<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Resource Bindings
    |--------------------------------------------------------------------------
    |
    | Mapping between resource contracts and their implementations.
    |
    */

    \Narsil\Cms\Contracts\Resources\EntityResource::class => \Narsil\Cms\Implementations\Resources\EntityResource::class,
    \Narsil\Cms\Contracts\Resources\UserResource::class => \Narsil\Cms\Implementations\Resources\UserResource::class,
];
