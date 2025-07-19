<?php

#region USE

use App\Constants\TanStackTable;
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

    TanStackTable::ACCESSOR_KEY => [],

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
    | This value overrides the visibility of each column.
    | This default visibility is false.
    |
    */

    TanStackTable::COLUMN_VISIBILITY => [
        SiteGroup::CREATED_AT => true,
        SiteGroup::ID         => true,
        SiteGroup::NAME       => true,
        SiteGroup::UPDATED_AT => true,
    ],
];
