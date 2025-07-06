<?php

namespace App\Services;

#region USE

use App\Structures\Column;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class TableService
{
    #region PUBLIC METHODS

    /**
     * @param string $table
     *
     * @return Collection<Column>
     */
    public static function getColumns(string $table): Collection
    {
        return Cache::rememberForever("tables:$table", function () use ($table)
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

    /**
     * @param string $columnName
     *
     * @return string
     */
    public static function getHeading(string $columnName): string
    {
        if (str_ends_with($columnName, '_id'))
        {
            $columnName = str_replace('_id', '', $columnName);
        }

        return trans("validation.attributes.$columnName");
    }

    #endregion
}
