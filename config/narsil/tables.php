<?php

#region USE

use Narsil\Implementations\Tables\BlockTable;
use Narsil\Implementations\Tables\EntityTable;
use Narsil\Implementations\Tables\FieldTable;
use Narsil\Implementations\Tables\RoleTable;
use Narsil\Implementations\Tables\SiteGroupTable;
use Narsil\Implementations\Tables\SiteTable;
use Narsil\Implementations\Tables\TemplateTable;
use Narsil\Implementations\Tables\UserTable;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Policies\Role;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SiteGroup;
use Narsil\Models\User;

#endregion

return [

    /*
    |--------------------------------------------------------------------------
    | Tables Implementations
    |--------------------------------------------------------------------------
    |
    | This file defines a mapping between table names and their templates.
    |
    */

    Block::TABLE => BlockTable::class,
    Entity::TABLE => EntityTable::class,
    Field::TABLE => FieldTable::class,
    Role::TABLE => RoleTable::class,
    SiteGroup::TABLE => SiteGroupTable::class,
    Site::TABLE => SiteTable::class,
    Template::TABLE => TemplateTable::class,
    User::TABLE => UserTable::class,
];
