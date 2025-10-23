<?php

use App\Http\Controllers\AdminController;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/admin', [AdminController::class, "index"]);

Route::post('/admin/login', [AdminController::class, "login"]);

Route::middleware(CheckAdmin::class)->group(function () {
    Route::prefix('/admin')->group(function () {
        Route::post('/logout', [AdminController::class, "logout"]);
        // Users
        Route::patch('users/{user}', [AdminController::class, "update"]);
    });
});



