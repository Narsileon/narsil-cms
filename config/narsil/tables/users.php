<?php

#region USE

use Narsil\Constants\TanStackTable;
use Narsil\Models\User;

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
    | This value overrides the default visibility of each column, which is false.
    |
    */

    TanStackTable::COLUMN_VISIBILITY => [
        User::EMAIL => true,
        User::FIRST_NAME => true,
        User::LAST_NAME  => true,
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
        User::EMAIL,
        User::FIRST_NAME,
        User::LAST_NAME,
    ],
];
