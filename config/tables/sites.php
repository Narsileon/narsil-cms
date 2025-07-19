<?php

#region USE

use App\Constants\TanStackTable;
use App\Models\Sites\Site;
use App\Models\Sites\SiteGroup;

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

    TanStackTable::ACCESSOR_KEY => [
        Site::GROUP_ID => Site::RELATION_GROUP . '.' . SiteGroup::NAME,
    ],

    /*
    |--------------------------------------------------------------------------
    | Column Order
    |--------------------------------------------------------------------------
    |
    | The value overrides the default order of each column, which is the migration order.
    |
    */

    TanStackTable::COLUMN_ORDER => [
        Site::ID,
        Site::NAME,
        Site::HANDLE,
        Site::LANGUAGE,
        Site::PRIMARY,
        Site::GROUP_ID,
        Site::CREATED_AT,
        Site::UPDATED_AT,
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
        Site::GROUP_ID => true,
        Site::HANDLE   => true,
        Site::LANGUAGE => true,
        Site::NAME     => true,
        Site::PRIMARY  => true,
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
        Site::NAME,
    ],
];
