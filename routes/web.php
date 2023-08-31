<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

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

Route::get('login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'postLogin']);

Route::get('register', [AuthController::class, 'register'])->name('register')->middleware('guest');
Route::post('register', [AuthController::class, 'store']);

Route::post('users/checkNewEmail', [UserController::class, 'checkNewEmail'])->name('users.checknewemail');

Route::group(['middleware' => ['auth']], function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('users/data', [UserController::class, 'getUsers'])->name('users.data');
    Route::post('users/checkEditEmail/{id}', [UserController::class, 'checkEditEmail'])->name('users.checkeditemail');
    Route::resource('users', UserController::class)->except(['create', 'show', 'edit']);
});
