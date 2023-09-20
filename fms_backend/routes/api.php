<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PhotoController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\VehicleTypeController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Admin\FuelManagementController;
use App\Http\Controllers\Admin\MaintenanceTypeController;
use App\Http\Controllers\Admin\VehicleMaintenanceController;
use App\Http\Controllers\Admin\VehicleInspectionController;
use App\Http\Controllers\Admin\VpcController;
use App\Http\Controllers\Admin\RoadtaxExpiryController;
use App\Http\Controllers\Admin\DeductionTypeController;
use App\Http\Controllers\Admin\DeductionController;
use App\Http\Controllers\Admin\AllowanceTypeController;
use App\Http\Controllers\Admin\AllowanceController;

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
        Route::middleware('jwt.auth')->group(function () {
            Route::get('/profile', [AdminAuthController::class, 'profile']);
            Route::get('/refresh', [AdminAuthController::class, 'refresh']);
            Route::get('/image/{filename}', [PhotoController::class, 'image']);
            Route::get('/images', [PhotoController::class, 'get_all_images']);

            Route::group(['prefix' => 'driver'], function() {
                Route::get('/', [DriverController::class, 'index']);
                Route::post('store', [DriverController::class, 'store']);
                Route::get('edit/{id}', [DriverController::class, 'edit']);
                Route::post('update', [DriverController::class, 'update']);
                Route::post('delete', [DriverController::class, 'destroy']);
                Route::post('salary', [DriverController::class, 'salary']);
                Route::post('generate_payslip', [DriverController::class, 'generate_payslip']);
            });

            Route::group(['prefix' => 'company'], function() {
                Route::get('/', [CompanyController::class, 'index']);
                Route::post('store', [CompanyController::class, 'store']);
                Route::get('edit/{id}', [CompanyController::class, 'edit']);
                Route::post('update', [CompanyController::class, 'update']);
                Route::post('delete', [CompanyController::class, 'destroy']);
            });

            Route::group(['prefix' => 'vehicle-type'], function() {
                Route::get('/', [VehicleTypeController::class, 'index']);
                Route::post('store', [VehicleTypeController::class, 'store']);
                Route::get('edit/{id}', [VehicleTypeController::class, 'edit']);
                Route::post('update', [VehicleTypeController::class, 'update']);
                Route::post('delete', [VehicleTypeController::class, 'destroy']);
            });

            Route::group(['prefix' => 'vehicles'], function() {
                Route::get('/', [VehicleController::class, 'index']);
                Route::get('add', [VehicleController::class, 'add']);
                Route::post('store', [VehicleController::class, 'store']);
                Route::get('edit/{id}', [VehicleController::class, 'edit']);
                Route::post('update', [VehicleController::class, 'update']);
                Route::post('delete', [VehicleController::class, 'destroy']);
            });

            Route::group(['prefix' => 'fuel-management'], function() {
                Route::get('/', [FuelManagementController::class, 'index']);
                Route::post('store', [FuelManagementController::class, 'store']);
                Route::get('edit/{id}', [FuelManagementController::class, 'edit']);
                Route::post('update', [FuelManagementController::class, 'update']);
                Route::post('delete', [FuelManagementController::class, 'destroy']);
            });

            Route::group(['prefix' => 'maintenance-type'], function() {
                Route::get('/', [MaintenanceTypeController::class, 'index']);
                Route::post('store', [MaintenanceTypeController::class, 'store']);
                Route::get('edit/{id}', [MaintenanceTypeController::class, 'edit']);
                Route::post('update', [MaintenanceTypeController::class, 'update']);
                Route::post('delete', [MaintenanceTypeController::class, 'destroy']);
            });

            Route::group(['prefix' => 'vehicle-maintenance'], function() {
                Route::get('/', [VehicleMaintenanceController::class, 'index']);
                Route::post('store', [VehicleMaintenanceController::class, 'store']);
                Route::get('edit/{id}', [VehicleMaintenanceController::class, 'edit']);
                Route::post('update', [VehicleMaintenanceController::class, 'update']);
                Route::post('delete', [VehicleMaintenanceController::class, 'destroy']);
            });

            Route::group(['prefix' => 'vehicle-inspection'], function() {
                Route::get('/', [VehicleInspectionController::class, 'index']);
                Route::post('store', [VehicleInspectionController::class, 'store']);
                Route::get('edit/{id}', [VehicleInspectionController::class, 'edit']);
                Route::post('update', [VehicleInspectionController::class, 'update']);
                Route::post('delete', [VehicleInspectionController::class, 'destroy']);
            });

            Route::group(['prefix' => 'vpc'], function() {
                Route::get('/', [VpcController::class, 'index']);
                Route::post('store', [VpcController::class, 'store']);
                Route::get('edit/{id}', [VpcController::class, 'edit']);
                Route::post('update', [VpcController::class, 'update']);
                Route::post('delete', [VpcController::class, 'destroy']);
            });

            Route::group(['prefix' => 'roadtax'], function() {
                Route::get('/', [RoadtaxExpiryController::class, 'index']);
                Route::post('store', [RoadtaxExpiryController::class, 'store']);
                Route::get('edit/{id}', [RoadtaxExpiryController::class, 'edit']);
                Route::post('update', [RoadtaxExpiryController::class, 'update']);
                Route::post('delete', [RoadtaxExpiryController::class, 'destroy']);
            });

            Route::group(['prefix' => 'deduction-type'], function() {
                Route::get('/', [DeductionTypeController::class, 'index']);
                Route::post('store', [DeductionTypeController::class, 'store']);
                Route::get('edit/{id}', [DeductionTypeController::class, 'edit']);
                Route::post('update', [DeductionTypeController::class, 'update']);
                Route::post('delete', [DeductionTypeController::class, 'destroy']);
            });

            Route::group(['prefix' => 'deductions'], function() {
                Route::get('/', [DeductionController::class, 'index']);
                Route::post('store', [DeductionController::class, 'store']);
                Route::get('edit/{id}', [DeductionController::class, 'edit']);
                Route::post('update', [DeductionController::class, 'update']);
                Route::post('delete', [DeductionController::class, 'destroy']);
            });
            Route::group(['prefix' => 'allowance-type'], function() {
                Route::get('/', [AllowanceTypeController::class, 'index']);
                Route::post('store', [AllowanceTypeController::class, 'store']);
                Route::get('edit/{id}', [AllowanceTypeController::class, 'edit']);
                Route::post('update', [AllowanceTypeController::class, 'update']);
                Route::post('delete', [AllowanceTypeController::class, 'destroy']);
            });

            Route::group(['prefix' => 'allowances'], function() {
                Route::get('/', [AllowanceController::class, 'index']);
                Route::post('store', [AllowanceController::class, 'store']);
                Route::get('edit/{id}', [AllowanceController::class, 'edit']);
                Route::post('update', [AllowanceController::class, 'update']);
                Route::post('delete', [AllowanceController::class, 'destroy']);
            });

        });
});
});
