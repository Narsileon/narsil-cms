<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Model Policies
    |--------------------------------------------------------------------------
    |
    | This file defines a mapping between models and their policies.
    |
    */

    \Narsil\Models\Elements\Block::class => \Narsil\Policies\BlockPolicy::class,
    \Narsil\Models\Elements\Field::class => \Narsil\Policies\FieldPolicy::class,
    \Narsil\Models\Elements\Template::class => \Narsil\Policies\TemplatePolicy::class,
    \Narsil\Models\Entities\Entity::class => \Narsil\Policies\EntityPolicy::class,
    \Narsil\Models\Hosts\Host::class => \Narsil\Policies\HostPolicy::class,
    \Narsil\Models\Policies\Role::class => \Narsil\Policies\RolePolicy::class,
    \Narsil\Models\User::class => \Narsil\Policies\UserPolicy::class,
];
