<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Model Tables
    |--------------------------------------------------------------------------
    |
    | Mapping between table names and their templates.
    |
    */

    \Narsil\Models\Collections\Block::TABLE => \Narsil\Implementations\Tables\BlockTable::class,
    \Narsil\Models\Collections\Field::TABLE => \Narsil\Implementations\Tables\FieldTable::class,
    \Narsil\Models\Collections\Template::TABLE => \Narsil\Implementations\Tables\TemplateTable::class,
    \Narsil\Models\Entities\Entity::TABLE => \Narsil\Implementations\Tables\EntityTable::class,
    \Narsil\Models\Forms\Fieldset::TABLE => \Narsil\Implementations\Tables\FieldsetTable::class,
    \Narsil\Models\Forms\Form::TABLE => \Narsil\Implementations\Tables\FormTable::class,
    \Narsil\Models\Forms\Input::TABLE => \Narsil\Implementations\Tables\InputTable::class,
    \Narsil\Models\Globals\Footer::TABLE => \Narsil\Implementations\Tables\FooterTable::class,
    \Narsil\Models\Globals\Header::TABLE => \Narsil\Implementations\Tables\HeaderTable::class,
    \Narsil\Models\Hosts\Host::TABLE => \Narsil\Implementations\Tables\HostTable::class,
    \Narsil\Models\Policies\Permission::TABLE => \Narsil\Implementations\Tables\PermissionTable::class,
    \Narsil\Models\Policies\Role::TABLE => \Narsil\Implementations\Tables\RoleTable::class,
    \Narsil\Models\User::TABLE => \Narsil\Implementations\Tables\UserTable::class,
];
