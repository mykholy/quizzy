<?php

use App\Http\Controllers\API\Admin\LocationAPIController;
use App\Http\Controllers\API\Auth\AuthClientAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'auth'], function () {
    Route::post('check-user', [AuthClientAPIController::class, 'check_user']);
    Route::post('login', [AuthClientAPIController::class, 'login']);
    Route::post('social-login', [AuthClientAPIController::class, 'socialLogin']);
    Route::post('logout', [AuthClientAPIController::class, 'logout']);
    Route::post('register', [AuthClientAPIController::class, 'register']);
    Route::get('profile', [AuthClientAPIController::class, 'profile']);
    Route::post('update-profile', [AuthClientAPIController::class, 'updateProfile']);

});

Route::get('settings', [AuthClientAPIController::class, 'settings']);

Route::resource('clients', App\Http\Controllers\API\Admin\ClientAPIController::class)
    ->only(['show', 'index'])
    ->names([
        'index' => 'admin.clients.index',
        'store' => 'admin.clients.store',
        'show' => 'admin.clients.show',
        'update' => 'admin.clients.update',
        'destroy' => 'admin.clients.destroy'
    ]);



Route::resource('cars', App\Http\Controllers\API\Admin\CarAPIController::class)
    ->only(['show', 'index'])
    ->names([
        'index' => 'admin.cars.index',
        'store' => 'admin.cars.store',
        'show' => 'admin.cars.show',
        'update' => 'admin.cars.update',
        'destroy' => 'admin.cars.destroy'
    ]);

Route::resource('amenities', App\Http\Controllers\API\Admin\AmenityAPIController::class)
    ->only(['show', 'index'])
    ->names([
        'index' => 'admin.amenities.index',
        'store' => 'admin.amenities.store',
        'show' => 'admin.amenities.show',
        'update' => 'admin.amenities.update',
        'destroy' => 'admin.amenities.destroy'
    ]);


Route::get('locations/make_favorite/{id}', [LocationAPIController::class, 'make_favorite'])->middleware('auth:api-client');
Route::get('locations/get_all_favorites', [LocationAPIController::class, 'get_all_favorites'])->middleware('auth:api-client');
Route::resource('locations', App\Http\Controllers\API\Admin\LocationAPIController::class)
    ->only(['show', 'index'])
    ->names([
        'index' => 'admin.locations.index',
        'store' => 'admin.locations.store',
        'show' => 'admin.locations.show',
        'update' => 'admin.locations.update',
        'destroy' => 'admin.locations.destroy'
    ]);

Route::resource('connectors', App\Http\Controllers\API\Admin\ConnectorAPIController::class)
    ->only(['show', 'index'])
    ->names([
        'index' => 'admin.connectors.index',
        'store' => 'admin.connectors.store',
        'show' => 'admin.connectors.show',
        'update' => 'admin.connectors.update',
        'destroy' => 'admin.connectors.destroy'
    ]);



Route::resource('stations', App\Http\Controllers\API\Admin\StationAPIController::class)
    ->only(['show', 'index'])
    ->names([
        'index' => 'admin.stations.index',
        'store' => 'admin.stations.store',
        'show' => 'admin.stations.show',
        'update' => 'admin.stations.update',
        'destroy' => 'admin.stations.destroy'
    ]);


Route::resource('admin/teachers', App\Http\Controllers\API\Admin\TeacherAPIController::class)
    ->except(['create', 'edit'])
    ->names([
        'index' => 'admin.teachers.index',
        'store' => 'admin.teachers.store',
        'show' => 'admin.teachers.show',
        'update' => 'admin.teachers.update',
        'destroy' => 'admin.teachers.destroy'
    ]);

Route::resource('admin/subjects', App\Http\Controllers\API\Admin\SubjectAPIController::class)
    ->except(['create', 'edit'])
    ->names([
        'index' => 'admin.subjects.index',
        'store' => 'admin.subjects.store',
        'show' => 'admin.subjects.show',
        'update' => 'admin.subjects.update',
        'destroy' => 'admin.subjects.destroy'
    ]);

Route::resource('admin/groups', App\Http\Controllers\API\Admin\GroupAPIController::class)
    ->except(['create', 'edit'])
    ->names([
        'index' => 'admin.groups.index',
        'store' => 'admin.groups.store',
        'show' => 'admin.groups.show',
        'update' => 'admin.groups.update',
        'destroy' => 'admin.groups.destroy'
    ]);

Route::resource('admin/students', App\Http\Controllers\API\Admin\StudentAPIController::class)
    ->except(['create', 'edit'])
    ->names([
        'index' => 'admin.students.index',
        'store' => 'admin.students.store',
        'show' => 'admin.students.show',
        'update' => 'admin.students.update',
        'destroy' => 'admin.students.destroy'
    ]);