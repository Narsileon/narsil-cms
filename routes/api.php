<?php

#region USE

use Illuminate\Support\Facades\Route;
use Narsil\Http\Controllers\Entities\EntityIndexController;

#endregion

Route::middleware([
    'auth:sanctum',
])->as('api.')->group(
    function ()
    {
        #region COLLECTIONS

        Route::controller(EntityIndexController::class)->group(function ()
        {
            Route::get('collections/{collection}', 'index')
                ->name('collections.index');
        });

        #endregion
    }
);
