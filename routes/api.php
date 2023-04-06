<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\ClassHPController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\SubjectController;
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
Route::post('/register', [UserController::class, 'store'])->name('register'); // dang ky
Route::get('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum'])->name('logout'); // dang xuat

Route::post('/forgot-password', [ResetPasswordController::class, 'forgotPass'])->middleware('guest')->name('password.email'); // gui mail kem link de reset pass
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'tokenReset'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'resetPass'])->middleware('guest')->name('password.update'); // reset pass


Route::prefix('v1')
    ->name('v1.')
    ->group(function () {
        Route::name('users.')
            ->prefix('users')
            ->group(function () {
                Route::get('/', [UserController::class, 'index'])->name('index'); // danh sach user
                Route::post('create', [UserController::class, 'create'])->name('create');
                Route::post('/store', [UserController::class, 'store'])->name('store'); // dang ky
                Route::post('update/{id}', [UserController::class, 'update'])->name('update');
                Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
            });

        Route::name('subjects.')
            ->prefix('subjects')
            ->group(function () {
                Route::get('/', [SubjectController::class, 'index'])->name('index'); // danh sach mon hoc
                Route::post('create', [SubjectController::class, 'create'])->name('create');
                Route::post('update', [SubjectController::class, 'update'])->name('update');
            });

        Route::name('semesters.')
            ->prefix('semesters')
            ->group(function (){
                Route::get('/', [SemesterController::class, 'index']);
                Route::get('/{id}', [SemesterController::class, 'show']);
            });

        Route::name('notifications.')
            ->prefix('notifications')
            ->group(function (){
                Route::get('/', [NotificationController::class, 'index']);
                Route::get('/{id}', [NotificationController::class, 'show']);
                Route::post('/', [NotificationController::class, 'store']);
            });

        Route::name('classes.')
            ->prefix('classes')
            ->group(function (){
                Route::get('/', [ClassHPController::class, 'index']);
            });

        Route::name('points.')
            ->prefix('points')
            ->group(function (){
                Route::get('/', [PointController::class, 'index']);
            });

    });
