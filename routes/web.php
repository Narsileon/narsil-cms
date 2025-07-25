<?php

#region USE

use Illuminate\Support\Facades\Route;
use Narsil\Http\Controllers\HomeController;
use Narsil\Http\Controllers\Resources\FieldController;
use Narsil\Http\Controllers\Resources\SiteController;
use Narsil\Http\Controllers\Resources\SiteGroupController;
use Narsil\Http\Controllers\Resources\UserController;
use Narsil\Http\Controllers\Users\SessionController;
use Narsil\Http\Controllers\Users\UserConfigurationController;

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

        Route::resource('/fields', FieldController::class)
            ->except([
                'show'
            ]);
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
