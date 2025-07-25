<?php

#region USE

use Narsil\Constants\TanStackTable;
use Narsil\Models\Fields\Field;

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
        Field::ID,
        Field::NAME,
        Field::HANDLE,
        Field::TYPE,
        Field::CREATED_AT,
        Field::UPDATED_AT,
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
        Field::HANDLE => true,
        Field::NAME => true,
        Field::TYPE => true,
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
        Field::NAME,
    ],
];
