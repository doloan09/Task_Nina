<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Site\ClassHPController;
use App\Http\Controllers\Site\ClassUserController;
use App\Http\Controllers\Site\NotificationController;
use App\Http\Controllers\Site\PointController;
use App\Http\Controllers\Site\SemesterController;
use App\Http\Controllers\Site\SubjectController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [AuthController::class, 'viewLogin'])->name('login.request');
Route::get('/register', [AuthController::class, 'viewRegister'])->name('register.request');

/// forgot password
Route::get('/forgot-password', [ResetPasswordController::class, 'showForgotPass'])->middleware('guest')->name('password.request'); // view forgot pass

Route::middleware('admin')->group(function (){
    Route::get('/', [AuthController::class, 'home'])->name('home');

    Route::prefix('users')
        ->group(function (){
            Route::get('/', [UserController::class, 'list'])->name('users.list'); // view danh sach user
            Route::get('/create', [UserController::class, 'create'])->name('users.create'); // view create user
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit'); // view edit user

        });

    Route::prefix('notifications')
        ->group(function (){
            Route::get('/', [NotificationController::class, 'list'])->name('notifications.list'); // view danh sach notifications
            Route::get('/{id}', [NotificationController::class, 'show'])->name('notifications.show'); // view danh sach notifications
            Route::get('/create', [NotificationController::class, 'create'])->name('notifications.create'); // view create notifications
            Route::get('/{id}/edit', [NotificationController::class, 'edit'])->name('notifications.edit'); // view edit notifications

        });

    Route::prefix('semesters')
        ->group(function (){
            Route::get('/', [SemesterController::class, 'list'])->name('semesters.list'); // view danh sach user
            Route::get('/create', [SemesterController::class, 'create'])->name('semesters.create'); // view create user
            Route::get('/{id}/edit', [SemesterController::class, 'viewUpdate'])->name('semesters.edit'); // view edit user

        });

    Route::prefix('subjects')
        ->group(function (){
            Route::get('/', [SubjectController::class, 'list'])->name('subjects.list'); // view danh sach user
            Route::get('/create', [SubjectController::class, 'create'])->name('subjects.create'); // view create user
            Route::get('/{id}/edit', [SubjectController::class, 'edit'])->name('subjects.edit'); // view edit user

        });

    Route::prefix('classes')
        ->group(function (){
            Route::get('/', [ClassHPController::class, 'list'])->name('classes.list'); // view danh sach user
            Route::get('/create', [ClassHPController::class, 'create'])->name('classes.create'); // view create user
            Route::get('/{id}/edit', [ClassHPController::class, 'edit'])->name('classes.edit'); // view edit user

        });

    Route::prefix('class-user')
        ->group(function (){
            Route::get('/', [ClassUserController::class, 'list'])->name('class-user.list'); // view danh sach user

        });
    Route::prefix('points')
        ->group(function (){
            Route::get('/', [PointController::class, 'list'])->name('points.list'); // view danh sach user
            Route::get('/create', [PointController::class, 'create'])->name('points.create'); // view create user
            Route::get('/{id}/edit', [PointController::class, 'edit'])->name('points.edit'); // view edit user

        });

});
