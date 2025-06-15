<?php

#region USE

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

#endregion

Route::get('/', HomeController::class);
