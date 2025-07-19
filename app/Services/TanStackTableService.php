<?php

namespace App\Services;

#region USE

use App\Constants\TanStackTable;
use App\Support\Column;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class TanStackTableService
{
    #region PUBLIC METHODS

    /**
     * @param string $table
     * @param array $hidden
     *
     * @return array
     */
    public static function getColumns(string $table, array $hidden = []): array
    {
        return Cache::rememberForever("tan-stack-tables:$table", function () use ($table, $hidden)
        {
            $columns = TableService::getColumns($table);

            $accessorKeys =  Config::get("tables.$table.accessor_keys", []);

            $columns = $columns->reject(function (Column $column) use ($hidden)
            {
                return in_array($column->name, $hidden);
            });

            $columns = $columns->map(function (Column $column) use ($accessorKeys, $hidden)
            {
                if (in_array($column->name, $hidden))
                {
                    return null;
                }

                return [
                    TanStackTable::ACCESSOR_KEY => Arr::get($accessorKeys, $column->name, $column->name),
                    TanStackTable::HEADER       => TableService::getHeading($column->name),
                    TanStackTable::ID           => $column->name,
                    TanStackTable::TYPE         => $column->type,
                ];
            })->filter();

            $columnNames = $columns->pluck(TanStackTable::ID)->all();

            return [
                'columns'          => $columns->values()->toArray(),
                'columnOrder'      => static::getColumnOrder($table, $columnNames),
                'columnVisibility' => static::getColumnVisibility($table, $columnNames),
            ];
        });
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @param string $table
     * @param array $columnNames
     *
     * @return array
     */
    private static function getColumnOrder(string $table, array $columnNames): array
    {
        $columnOrder = Config::get("tables.$table.column_order", []);

        foreach ($columnNames as $columnName)
        {
            if (!array_key_exists($columnName, $columnOrder))
            {
                $columnOrder[] = $columnName;
            }
        }

        return $columnOrder;
    }

    /**
     * @param string $table
     * @param array $columnNames
     *
     * @return array
     */
    private static function getColumnVisibility(string $table, array $columnNames): array
    {
        $columnVisibility = Config::get("tables.$table.column_visibility", []);

        foreach ($columnNames as $columnName)
        {
            if (!array_key_exists($columnName, $columnVisibility))
            {
                $columnVisibility[$columnName] = false;
            }
        }

        return $columnVisibility;
    }

    #endregion
}
