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

    \Narsil\Contracts\Resources\EntityResource::class => \Narsil\Implementations\Resources\EntityResource::class,
    \Narsil\Contracts\Resources\UserResource::class => \Narsil\Implementations\Resources\UserResource::class,
];
