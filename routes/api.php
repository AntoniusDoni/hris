<?php

use App\Http\Controllers\Api\DivisionController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\AuthApiController;
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

Route::get('/roles', [RoleController::class, 'index'])->name('api.role.index');
Route::get('/divisions', [DivisionController::class, 'index'])->name('api.division.index');
Route::get('/positions', [PositionController::class, 'index'])->name('api.position.index');
Route::get('/scheduler', [ScheduleController::class, 'index'])->name('api.scheduler.index');
Route::get('/employee', [EmployeeController::class, 'index'])->name('api.employee.index');

Route::post('login', [AuthApiController::class, 'authenticate']);
Route::group(['prefix'=>'v1','middleware' => ['api','jwt.verify']], function() {
    Route::get('logout', [AuthApiController::class, 'logout']);
    Route::get('user', [AuthApiController::class, 'get_user']);
    Route::get('refresh-token', [AuthApiController::class, 'refreshtoken']);
    // Route::get('products/{id}', [ProductController::class, 'show']);
    // Route::post('create', [ProductController::class, 'store']);
    // Route::put('update/{product}',  [ProductController::class, 'update']);
    // Route::delete('delete/{product}',  [ProductController::class, 'destroy']);
});
