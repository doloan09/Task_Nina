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

Route::middleware('auth')->group(function (){

    Route::middleware('role-admin')
        ->group(function (){
            Route::get('/', [AuthController::class, 'home'])->name('home');
            Route::get('/home', [AuthController::class, 'home'])->name('home');

            Route::get('users/', [UserController::class, 'list'])->name('users.list'); // view danh sach user
            Route::resource('users', UserController::class)->only([
                'create', 'edit'
            ]);

            Route::get('semesters/', [SemesterController::class, 'list'])->name('semesters.list'); // danh sach cac hoc ky
            Route::get('subjects/', [SubjectController::class, 'list'])->name('subjects.list'); // danh sach cac mon hoc

        });

    Route::middleware('role-admin-student')->prefix('classes')
        ->group(function (){
            Route::get('/', [ClassHPController::class, 'list'])->name('classes.list'); // danh sach lop hoc phan
            Route::get('/user', [ClassHPController::class, 'view_show'])->name('classes.show'); // view danh sach user trong mot lop

        });

    // phan giang
    Route::middleware('role-admin-teacher')->get('class-user/', [ClassUserController::class, 'list'])->name('class-user.list');

    // point
    Route::get('points/', [PointController::class, 'list'])->name('points.list');

    // notifications
    Route::get('notifications/', [NotificationController::class, 'list'])->name('notifications.list'); // view danh sach notifications
    Route::resource('notifications', NotificationController::class)->only([
        'show', 'edit'
    ]);

});
