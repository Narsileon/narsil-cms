<?php

namespace App\Services;

#region USE

use App\Structures\Column;
use App\Structures\ColumnDefinition;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
final class TableService
{
    #region PUBLIC METHODS

    /**
     * @param string $table
     *
     * @return Collection<ColumnDefinition>
     */
    public static function getColumnDefinitions(string $table): Collection
    {
        $columns = static::getColumns($table);

        return $columns->map(function (Column $column)
        {
            return new ColumnDefinition($column);
        });
    }

    /**
     * @param string $table
     *
     * @return Collection<Column>
     */
    public static function getColumns(string $table): Collection
    {
        return Cache::rememberForever("schema:$table", function () use ($table)
        {
            $tableColumns = collect([]);

            $columns = Schema::getColumns($table);

            foreach ($columns as $column)
            {
                $tableColumn = new Column($column);

                $tableColumns->put($tableColumn->name, $tableColumn);
            }

            return $tableColumns;
        });
    }

    #endregion
}
