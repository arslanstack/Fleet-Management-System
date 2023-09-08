<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\AdminApi\AuthController;
use App\Http\Controllers\Admin\AdminApiController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::group(['prefix'  =>  'admin'], function () {
//     Route::post('/login', [AuthController::class, 'login'])->name('login');
// });


Route::middleware(['api'])->group(function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::post('/login', [AdminApiController::class, 'login'])->name('login');
        Route::post('/logout', [AdminApiController::class, 'logout'])->name('logout');
        Route::get('/profile', [AdminApiController::class, 'profile']);
        Route::get('/refresh', [AdminApiController::class, 'refresh']);
    });
});
