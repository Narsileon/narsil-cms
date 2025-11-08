<?php

#region USE

use Illuminate\Support\Facades\Route;
use Narsil\Http\Controllers\PageController;

#endregion

Route::get('/{path?}', PageController::class)
    ->where('path', '.*');

Route::domain('{subdomain}')
    ->get('/{path?}', PageController::class)
    ->where('path', '.*');
