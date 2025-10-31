<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Tables Implementations
    |--------------------------------------------------------------------------
    |
    | Mapping between table names and their templates.
    |
    */

    \Narsil\Models\Elements\Block::TABLE => \Narsil\Implementations\Tables\BlockTable::class,
    \Narsil\Models\Elements\Field::TABLE => \Narsil\Implementations\Tables\FieldTable::class,
    \Narsil\Models\Elements\Template::TABLE => \Narsil\Implementations\Tables\TemplateTable::class,
    \Narsil\Models\Entities\Entity::TABLE => \Narsil\Implementations\Tables\EntityTable::class,
    \Narsil\Models\Hosts\Host::TABLE => \Narsil\Implementations\Tables\HostTable::class,
    \Narsil\Models\Policies\Role::TABLE => \Narsil\Implementations\Tables\RoleTable::class,
    \Narsil\Models\User::TABLE => \Narsil\Implementations\Tables\UserTable::class,
];
