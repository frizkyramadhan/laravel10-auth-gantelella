<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('layouts.main', [
        'title' => 'Dashboard'
    ]);
});

Route::get('users/data', [UserController::class, 'getUsers'])->name('users.data');
Route::post('users/checkNewEmail', [UserController::class, 'checkNewEmail'])->name('users.checknewemail');
Route::post('users/checkEditEmail/{id}', [UserController::class, 'checkEditEmail'])->name('users.checkeditemail');
Route::resource('users', UserController::class)->except(['create', 'show', 'edit']);
