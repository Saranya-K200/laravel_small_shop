<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\WelcomeEmailController;

Route::get('/send-welcome-email', [WelcomeEmailController::class, 'index']);