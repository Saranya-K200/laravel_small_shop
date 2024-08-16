<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\http\Controllers\HomeController;

Route::get('/thirumal',[HomeController::class, 'sendEmailManually'])->name('home.sendEmailManually');