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

    \Narsil\Models\Entities\Entity::class => \Narsil\Implementations\Resources\EntityResource::class,
    \Narsil\Models\Entities\EntityBlock::class => \Narsil\Implementations\Resources\EntityBlockResource::class,
    \Narsil\Models\User::class => \Narsil\Implementations\Resources\UserResource::class,
];
