<?php

#region USE

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Resources\SiteController;
use App\Http\Controllers\Resources\SiteGroupController;
use App\Http\Controllers\Resources\UserController;
use App\Http\Controllers\Users\SessionController;
use App\Http\Controllers\Users\UserConfigurationController;
use Illuminate\Support\Facades\Route;

#endregion

Route::middleware([
    'web',
    'auth',
    'verified',
])->group(
    function ()
    {
        Route::get('/', HomeController::class)
            ->name('home');

        #region RESOURCES

        Route::resource('/site-groups', SiteGroupController::class)
            ->except([
                'show'
            ]);
        Route::resource('/sites', SiteController::class)
            ->except([
                'show'
            ]);
        Route::resource('/users', UserController::class)
            ->except([
                'show'
            ]);

        #endregion

        #region USERS

        Route::delete('/sessions', SessionController::class)
            ->name('sessions.delete');

        #endregion
    }
);

Route::middleware([
    'web',
])->group(
    function ()
    {
        #region USERS

        Route::resource('/user-configuration', UserConfigurationController::class)
            ->only([
                'index',
                'store',
            ]);

        #endregion
    }
);
