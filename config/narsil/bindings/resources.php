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
    \Narsil\Contracts\Resources\FieldsetResource::class => \Narsil\Implementations\Resources\FieldsetResource::class,
    \Narsil\Contracts\Resources\FormResource::class => \Narsil\Implementations\Resources\FormResource::class,
    \Narsil\Contracts\Resources\InputOptionResource::class => \Narsil\Implementations\Resources\InputOptionResource::class,
    \Narsil\Contracts\Resources\InputResource::class => \Narsil\Implementations\Resources\InputResource::class,
    \Narsil\Contracts\Resources\UserResource::class => \Narsil\Implementations\Resources\UserResource::class,
];
