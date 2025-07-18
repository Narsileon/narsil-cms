<?php

namespace App\Services;

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
    public static function getRouteNames(string $table): array
    {
        $tableName = Str::slug($table);

        $routeNames = [
            'create'  => "$tableName.create",
            'destroy' => "$tableName.destroy",
            'edit'    => "$tableName.edit",
            'index'   => "$tableName.index",
            'show'    => "$tableName.show",
            'store'   => "$tableName.store",
            'update'  => "$tableName.update",
        ];

        return array_filter($routeNames, function ($routeName)
        {
            return Route::has($routeName);
        });
    }

    #endregion
}
