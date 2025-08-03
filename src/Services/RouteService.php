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
     *
     * @return array
     */
    public static function getNames(string $table): array
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

        return array_filter($names, function ($name)
        {
            return Route::has($name);
        });
    }

    #endregion
}
