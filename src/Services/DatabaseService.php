<?php

namespace Narsil\Cms\Services;

#region USE

use Illuminate\Database\Eloquent\Model;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class DatabaseService
{
    #region PUBLIC METHODS

    /**
     * @param Model $model
     * @param string $column
     * @param mixed $value
     *
     * @return string
     */
    public static function generateUniqueValue(Model $model, string $column, mixed $value): string
    {
        $count = 1;

        $uniqueValue = "{$value}_{$count}";

        while ($model->newQuery()->where($column, $uniqueValue)->exists())
        {
            $count++;

            $uniqueValue = "{$value}_{$count}";
        }

        return $uniqueValue;
    }

    #endregion
}
