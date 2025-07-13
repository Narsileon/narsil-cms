<?php

#region USE

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Resources\SiteController;
use App\Http\Controllers\Resources\SiteGroupController;
use App\Http\Controllers\Resources\UserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserConfigurationController;
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
        Route::get('/settings', SettingsController::class)
            ->name('settings');

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

        #region SESSIONS

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
        Route::resource('/user-configuration', UserConfigurationController::class)
            ->only([
                'index',
                'store',
            ]);
    }
);
