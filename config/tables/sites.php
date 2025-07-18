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
    | This value overrides the accessor keys of each column.
    | The default accessor key is the column name.
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
    | The value defines the order of each column.
    | The default order is the migration order.
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
    | This value overrides the visibility of each column.
    | This default visibility is false.
    |
    */

    TanStackTable::COLUMN_VISIBILITY => [
        Site::GROUP_ID => true,
        Site::HANDLE => true,
        Site::LANGUAGE => true,
        Site::NAME => true,
        Site::PRIMARY => true,
    ],
];
