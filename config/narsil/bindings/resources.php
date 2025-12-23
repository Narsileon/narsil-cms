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

    \Narsil\Contracts\Resources\EntityBlockResource::class => \Narsil\Implementations\Resources\EntityBlockResource::class,
    \Narsil\Contracts\Resources\EntityResource::class => \Narsil\Implementations\Resources\EntityResource::class,
    \Narsil\Contracts\Resources\FooterResource::class => \Narsil\Implementations\Resources\FooterResource::class,
    \Narsil\Contracts\Resources\FooterSocialLinkResource::class => \Narsil\Implementations\Resources\FooterSocialLinkResource::class,
    \Narsil\Contracts\Resources\HeaderResource::class => \Narsil\Implementations\Resources\HeaderResource::class,
    \Narsil\Contracts\Resources\SitePageResource::class => \Narsil\Implementations\Resources\SitePageResource::class,
    \Narsil\Contracts\Resources\SitePageUrlResource::class => \Narsil\Implementations\Resources\SitePageUrlResource::class,
    \Narsil\Contracts\Resources\UserResource::class => \Narsil\Implementations\Resources\UserResource::class,
];
