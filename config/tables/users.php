<?php

#region USE

use App\Constants\TanStackTable;
use App\Models\User;

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
        User::ID,
        User::EMAIL,
        User::FIRST_NAME,
        User::LAST_NAME,
        User::CREATED_AT,
        User::UPDATED_AT,
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
        User::EMAIL      => true,
        User::FIRST_NAME => true,
        User::LAST_NAME  => true,
    ],
];
