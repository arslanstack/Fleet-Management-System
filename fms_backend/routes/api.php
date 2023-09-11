<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\CompanyController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::group(['prefix'  =>  'admin'], function () {
//     Route::post('/login', [AuthController::class, 'login'])->name('login');
// });


Route::middleware(['api'])->group(function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/profile', [AdminAuthController::class, 'profile']);
        Route::get('/refresh', [AdminAuthController::class, 'refresh']);

        Route::group(['prefix' => 'driver'], function() {
            Route::get('/', [DriverController::class, 'index']);
            Route::post('store', [DriverController::class, 'store']);
            Route::get('edit/{id}', [DriverController::class, 'edit']);
            Route::post('update', [DriverController::class, 'update']);
            Route::post('delete', [DriverController::class, 'destroy']);
        });

        Route::group(['prefix' => 'company'], function() {
            Route::get('/', [CompanyController::class, 'index']);
            Route::post('store', [CompanyController::class, 'store']);
            Route::get('edit/{id}', [CompanyController::class, 'edit']);
            Route::post('update', [CompanyController::class, 'update']);
            Route::post('delete', [CompanyController::class, 'destroy']);
        });
    });
});
