<?php

namespace Narsil\Services;

#region USE

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Narsil\Support\DatabaseColumn;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
abstract class TableService
{
    #region PUBLIC METHODS

    /**
     * @param string $table
     *
     * @return Collection<string,DatabaseColumn>
     */
    public static function getColumns(string $table): Collection
    {
        return Cache::rememberForever("narsil.tables:$table", function () use ($table)
        {
            $tableColumns = collect([]);

            $columns = Schema::getColumns($table);

            foreach ($columns as $column)
            {
                $tableColumn = new DatabaseColumn($column);

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

        return Str::ucfirst(trans("narsil::validation.attributes.$columnName"));
    }

    #endregion
}
