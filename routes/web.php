<?php

#region USE

use Illuminate\Support\Facades\Route;
use Narsil\Http\Controllers\DashboardController;
use Narsil\Http\Controllers\FieldController;
use Narsil\Http\Controllers\FieldSetController;
use Narsil\Http\Controllers\RoleController;
use Narsil\Http\Controllers\SessionController;
use Narsil\Http\Controllers\SiteController;
use Narsil\Http\Controllers\SiteGroupController;
use Narsil\Http\Controllers\TemplateController;
use Narsil\Http\Controllers\UserConfigurationController;
use Narsil\Http\Controllers\UserController;

#endregion

Route::middleware([
    'web',
    'auth',
    'verified',
])->group(
    function ()
    {
        Route::get('/', DashboardController::class)
            ->name('dashboard');

        #region RESOURCES

        Route::resource('/field-sets', FieldSetController::class)
            ->except([
                'show'
            ]);
        Route::resource('/fields', FieldController::class)
            ->except([
                'show'
            ]);
        Route::resource('/roles', RoleController::class)
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
        Route::resource('/templates', TemplateController::class)
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
