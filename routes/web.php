<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/account', [AccountController::class, 'index']);
Route::post('/account/deposit', [AccountController::class, 'deposit']);
Route::post('/account/withdraw', [AccountController::class, 'withdraw']);
