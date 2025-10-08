<?php

#region USE

use Illuminate\Support\Facades\Route;
use Narsil\Http\Controllers\PageController;

#endregion

Route::domain('{subdomain}')
    ->get('/{slug?}', PageController::class)
    ->where('slug', '.*');

Route::get('/{slug?}', PageController::class)
    ->where('slug', '.*');
