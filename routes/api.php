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
                Route::post('/import', [UserController::class, 'import'])->name('import');
                Route::post('/update/{id}', [UserController::class, 'update'])->name('updated');
                Route::get('/top', [UserController::class, 'topSV'])->name('top'); // danh sach user
                Route::get('/point-info', [UserController::class, 'point'])->name('point_info'); // danh sach user
            });

        Route::apiResource('users', UserController::class)->only([
            'index', 'store', 'destroy'
        ]);

        // subjects
        Route::post('subjects/update/{id}', [SubjectController::class, 'update'])->name('subjects.update');
        Route::apiResource('subjects', SubjectController::class)->only([
            'index', 'store', 'destroy'
        ]);

        // semesters
        Route::post('semesters/update/{id}', [SemesterController::class, 'update'])->name('semesters.update');
        Route::apiResource('semesters', SemesterController::class)->only([
            'index', 'store', 'destroy'
        ]);

        // notifications
        Route::name('notifications.')
            ->prefix('notifications')
            ->group(function (){
                Route::get('/newest', [NotificationController::class, 'listNotificationNewest'])->name('newest');
                Route::post('/send', [NotificationController::class, 'send'])->name('send');
                Route::post('/update/{id}', [NotificationController::class, 'update'])->name('update');
            });

        Route::apiResource('notifications', NotificationController::class)->only([
            'index', 'store', 'destroy'
        ]);

        // classes
        Route::post('classes/update/{id}', [ClassHPController::class, 'update'])->name('classes.update');
        Route::apiResource('classes', ClassHPController::class)->only([
            'index', 'show', 'store', 'destroy'
        ]);

        // class-user
        Route::post('class-user/update/{id}', [ClassUserController::class, 'update'])->name('class-user.update');
        Route::apiResource('class-user', ClassUserController::class)->only([
            'index', 'store', 'destroy'
        ]);

        // point
        Route::name('points.')
            ->prefix('points')
            ->group(function (){
                Route::get('/export', [PointController::class, 'export'])->name('export');
                Route::post('/import', [PointController::class, 'import'])->name('import');
                Route::post('/update/{id}', [PointController::class, 'update'])->name('update');
            });

        Route::apiResource('points', PointController::class)->only([
            'index', 'show', 'store', 'destroy'
        ]);

    });
