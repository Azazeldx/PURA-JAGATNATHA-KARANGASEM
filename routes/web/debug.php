<?php

use App\Http\Controllers\DebugController;
use Illuminate\Support\Facades\Route;

Route::prefix('debug')->group(function () {

    Route::controller(DebugController::class)->group(function () {
        Route::get('/mail', 'mail');
        Route::get('/index', 'index');
    });

});