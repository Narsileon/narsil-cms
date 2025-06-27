<?php

#region USE

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Sessions\SessionDeleteController;
use App\Http\Controllers\Sessions\SessionLocaleUpdateController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Sites\SiteController;
use App\Http\Controllers\Users\UserConfigurationUpdateController;
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

        Route::resource('/sites', SiteController::class)
            ->except([
                'show'
            ]);

        Route::patch('/sessions/locale', SessionLocaleUpdateController::class)
            ->name('sessions-locale.update');
        Route::delete('/sessions', SessionDeleteController::class)
            ->name('sessions.delete');

        Route::patch('/user/configuration', UserConfigurationUpdateController::class)
            ->name('user-configuration.update');
    }
);
