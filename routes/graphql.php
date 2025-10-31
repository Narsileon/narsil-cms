<?php

#region USE

use Illuminate\Support\Facades\Route;
use Narsil\Http\Controllers\GraphQL\GraphiQLController;

#endregion

Route::get('/graphiql', GraphiQLController::class)
    ->name('graphiql');
