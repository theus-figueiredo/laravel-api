<?php

use App\Http\Controllers\Api\Auth\LoginJwtController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\RealStateController;
use App\Http\Controllers\Api\RealStatePhotoController;
use App\Http\Controllers\Api\UserController;
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


Route::prefix('v1')->namespace('App\Http\Controllers\Api')->group(function() {

    Route::name('real_states.')->prefix('real-states')->group(function() {
        Route::get('/', [RealStateController::class, 'index']); //api/v1/real-state/
        Route::get('/{id}', [RealStateController::class, 'show']); //api/v1/real-state/{id}
        Route::post('/', [RealStateController::class, 'store'])->middleware('jwt.auth'); //api/v1/real-state/
        Route::put('/{id', [RealStateController::class, 'update'])->middleware('jwt.auth'); //api/v1/real-state/{id}
        Route::delete('/{id', [RealStateController::class, 'destroy'])->middleware('jwt.auth'); //api/v1/real-state/{id}
    });

    Route::name('users.')->prefix('users')->group(function() {
        Route::get('/', [UserController::class, 'index'])->middleware('jwt.auth'); //api/v1/users/
        Route::post('/', [UserController::class, 'store']); //api/v1/users/
        Route::put('/{id', [UserController::class, 'update'])->middleware('jwt.auth'); //api/v1/users/{id}
        Route::delete('/{id', [UserController::class, 'destroy'])->middleware('jwt.auth'); //api/v1/users/{id}
        Route::post('/login', [LoginJwtController::class, 'login']); //api/v1/users/login/
        Route::get('/logout', [LoginJwtController::class, 'logout']); //api/v1/users/logout/
        Route::get('/refresh', [LoginJwtController::class, 'refresh']); //api/v1/users/refresh/
    });

    Route::group(['middleware' => ['jwt.auth']], function() {
        Route::name('categories.')->group(function() {
            Route::get('/categories/{id}/real-states', [CategoryController::class, 'realState']); //api/v1/categories/{id}/real-states
            Route::resource('/categories', CategoryController::class); //api/v1/categories/
        });   
        
        Route::name('photos.')->prefix('photos')->group(function() {
            Route::delete('/{id}', [RealStatePhotoController::class, 'removePhoto'])->name('delete'); //api/v1/photos/{id}/
            Route::put('/set-thumb/{photoId}/{realStateId}', [RealStatePhotoController::class, 'setThumb']);//api/v1/photos/set-thumb/{photoId}/{realStateId}/
        });

        Route::get('/user-real-state', [RealStateController::class, 'getUserRealStates']); //api/v1/user-real-state/
    });
});
