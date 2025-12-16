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

    \Narsil\Models\Entities\Entity::class => \Narsil\Http\Resources\Entities\EntityResource::class,
    \Narsil\Models\Entities\EntityBlock::class => \Narsil\Http\Resources\Entities\EntityBlockResource::class,
    \Narsil\Models\User::class => \Narsil\Http\Resources\UserResource::class,
];
