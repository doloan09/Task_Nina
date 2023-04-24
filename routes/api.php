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


Route::middleware(['auth:sanctum'])
    ->prefix('v1')
    ->name('v1.')
    ->group(function () {
        Route::name('users.')
            ->prefix('users')
            ->group(function () {
                Route::get('/', [UserController::class, 'index'])->name('index'); // danh sach user
                Route::post('/store', [UserController::class, 'store'])->name('store'); // dang ky
                Route::post('/import', [UserController::class, 'import'])->name('import');
                Route::post('/update/{id}', [UserController::class, 'update'])->name('updated');
                Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
                Route::get('/top', [UserController::class, 'topSV'])->name('top'); // danh sach user
                Route::get('/point-info', [UserController::class, 'point'])->name('point_info'); // danh sach user
            });

        Route::name('subjects.')
            ->prefix('subjects')
            ->group(function () {
                Route::get('/', [SubjectController::class, 'index'])->name('index'); // danh sach mon hoc
                Route::post('/store', [SubjectController::class, 'store'])->name('store');
                Route::post('/update/{id}', [SubjectController::class, 'update'])->name('update');
                Route::delete('/{id}', [SubjectController::class, 'destroy'])->name('destroy');
            });

        Route::name('semesters.')
            ->prefix('semesters')
            ->group(function (){
                Route::get('/', [SemesterController::class, 'index'])->name('index');
                Route::post('/store', [SemesterController::class, 'store'])->name('store');
                Route::post('/update/{id}', [SemesterController::class, 'update'])->name('update');
                Route::delete('/{id}', [SemesterController::class, 'destroy'])->name('destroy');
            });

        Route::name('notifications.')
            ->prefix('notifications')
            ->group(function (){
                Route::get('/', [NotificationController::class, 'index'])->name('index');
                Route::get('/newest', [NotificationController::class, 'listNotificationNewest'])->name('newest');
                Route::post('/store', [NotificationController::class, 'store'])->name('store');
                Route::post('/send', [NotificationController::class, 'send'])->name('send');
                Route::post('/update/{id}', [NotificationController::class, 'update'])->name('update');
                Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
            });

        Route::name('classes.')
            ->prefix('classes')
            ->group(function (){
                Route::get('/', [ClassHPController::class, 'index'])->name('index');
                Route::get('/{id}', [ClassHPController::class, 'show'])->name('show');
                Route::post('/store', [ClassHPController::class, 'store'])->name('store');
                Route::post('/update/{id}', [ClassHPController::class, 'update'])->name('update');
                Route::delete('/{id}', [ClassHPController::class, 'destroy'])->name('destroy');
            });

        Route::name('class-user.')
            ->prefix('class-user')
            ->group(function (){
                Route::get('/', [ClassUserController::class, 'index'])->name('index');
                Route::post('/store', [ClassUserController::class, 'store'])->name('store');
                Route::post('/update/{id}', [ClassUserController::class, 'update'])->name('update');
                Route::delete('/{id}', [ClassUserController::class, 'destroy'])->name('destroy');
            });

        Route::name('points.')
            ->prefix('points')
            ->group(function (){
                Route::get('/', [PointController::class, 'index'])->name('index');
                Route::get('/export', [PointController::class, 'export'])->name('export');
                Route::get('/{id}', [PointController::class, 'show'])->name('show');
                Route::post('/store', [PointController::class, 'store'])->name('store');
                Route::post('/import', [PointController::class, 'import'])->name('import');
                Route::post('/update/{id}', [PointController::class, 'update'])->name('update');
                Route::delete('/{id}', [PointController::class, 'destroy'])->name('destroy');
            });

    });
