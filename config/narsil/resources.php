<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Model Resources
    |--------------------------------------------------------------------------
    |
    | Mapping between models and their resources.
    |
    */

    \Narsil\Contracts\Resources\EntityBlockResource::class => \Narsil\Implementations\Resources\EntityBlockResource::class,
    \Narsil\Contracts\Resources\EntityResource::class => \Narsil\Implementations\Resources\EntityResource::class,
    \Narsil\Contracts\Resources\SitePageResource::class => \Narsil\Implementations\Resources\SitePageResource::class,
    \Narsil\Contracts\Resources\SitePageUrlResource::class => \Narsil\Implementations\Resources\SitePageUrlResource::class,
    \Narsil\Contracts\Resources\UserResource::class => \Narsil\Implementations\Resources\UserResource::class,
];
