<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Tables Implementations
    |--------------------------------------------------------------------------
    |
    | This file defines a mapping between table contracts and their concrete implementations.
    |
    */

    \Narsil\Contracts\Tables\BlockTable::class => \Narsil\Implementations\Tables\BlockTable::class,
    \Narsil\Contracts\Tables\EntityTable::class => \Narsil\Implementations\Tables\EntityTable::class,
    \Narsil\Contracts\Tables\FieldTable::class => \Narsil\Implementations\Tables\FieldTable::class,
    \Narsil\Contracts\Tables\RoleTable::class => \Narsil\Implementations\Tables\RoleTable::class,
    \Narsil\Contracts\Tables\SiteGroupTable::class => \Narsil\Implementations\Tables\SiteGroupTable::class,
    \Narsil\Contracts\Tables\SiteTable::class => \Narsil\Implementations\Tables\SiteTable::class,
    \Narsil\Contracts\Tables\TemplateTable::class => \Narsil\Implementations\Tables\TemplateTable::class,
    \Narsil\Contracts\Tables\UserTable::class => \Narsil\Implementations\Tables\UserTable::class,
];
