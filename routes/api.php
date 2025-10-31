<?php

#region USE

use Illuminate\Support\Facades\Route;
use Narsil\Http\Controllers\Entities\EntityIndexController;

#endregion

Route::get('collections/{collection}', EntityIndexController::class)
    ->name('collections.index');
