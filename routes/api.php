<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// login
Route::post('/login', [AuthController::class, 'login'])->name('login'); // dang nhap
Route::post('users/create', [UserController::class, 'store'])->name('users.create'); // dang ky
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout'); // dang xuat

// user // , 'admin'
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index'); // danh sach user
});

Route::post('/forgot-password', [ResetPasswordController::class, 'forgotPass'])->middleware('guest')->name('password.email'); // gui mail kem link de reset pass
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'tokenReset'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'resetPass'])->middleware('guest')->name('password.update'); // reset pass

