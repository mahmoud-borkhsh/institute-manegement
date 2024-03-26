<?php

use App\Http\Controllers\AuthUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('login', [AuthUserController::class, 'login']);


Route::middleware('auth:teacher')->group(function () {
    Route::post('reset-password', [AuthUserController::class, 'resetPassword']);
});
