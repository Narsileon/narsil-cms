<?php

namespace Narsil\Services;

#region USE

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class RouteService
{
    #region PUBLIC METHODS

    /**
     * @param string $table
     * @param array $parameters
     *
     * @return array
     */
    public static function getNames(string $table, array $parameters = []): array
    {
        $tableName = Str::slug($table);

        $names = [
            'create' => "$tableName.create",
            'destroy' => "$tableName.destroy",
            'destroyMany' => "$tableName.destroyMany",
            'edit' => "$tableName.edit",
            'index' => "$tableName.index",
            'show' => "$tableName.show",
            'store' => "$tableName.store",
            'update' => "$tableName.update",
        ];

        $names = array_filter($names, function ($name)
        {
            return Route::has($name);
        });

        $names['params'] = $parameters;

        return $names;
    }

    #endregion
}
