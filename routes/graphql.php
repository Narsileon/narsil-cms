<?php

#region USE

use Illuminate\Support\Facades\Route;
use Narsil\Cms\Http\Controllers\GraphQL\GraphiQLController;

#endregion

Route::get('/graphiql', GraphiQLController::class)
    ->name('graphiql');
