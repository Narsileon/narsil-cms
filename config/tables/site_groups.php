<?php

#region USE

use Narsil\Constants\TanStackTable;
use Narsil\Models\Sites\SiteGroup;

#endregion

return [
    /*
    |--------------------------------------------------------------------------
    | Accessor Keys
    |--------------------------------------------------------------------------
    |
    | This value overrides the default accessor keys of each column, which is the column name.
    |
    */

    TanStackTable::ACCESSOR_KEY => [],

    /*
    |--------------------------------------------------------------------------
    | Column Order
    |--------------------------------------------------------------------------
    |
    | The value overrides the default order of each column, which is the migration order.
    |
    */

    TanStackTable::COLUMN_ORDER => [
        SiteGroup::ID,
        SiteGroup::NAME,
        SiteGroup::CREATED_AT,
        SiteGroup::UPDATED_AT,
    ],

    /*
    |--------------------------------------------------------------------------
    | Column Visibility
    |--------------------------------------------------------------------------
    |
    | This value overrides the default visibility of each column, which is false.
    |
    */

    TanStackTable::COLUMN_VISIBILITY => [
        SiteGroup::CREATED_AT => true,
        SiteGroup::ID         => true,
        SiteGroup::NAME       => true,
        SiteGroup::UPDATED_AT => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    |
    | This value defines the default searchable columns.
    |
    */

    TanStackTable::SEARCH => [
        SiteGroup::NAME,
    ],
];
