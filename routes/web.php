<?php

#region USE

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Sites\SiteController;
use Illuminate\Support\Facades\Route;

#endregion

Route::get('/', HomeController::class)
    ->name('home');
Route::get('/settings', SettingsController::class)
    ->name('settings');

Route::resource('/sites', SiteController::class)
    ->except([
        'show'
    ]);
