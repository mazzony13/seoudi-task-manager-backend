<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\Auth;
use App\Http\Controllers\Api\v1\Task;
use App\Http\Controllers\Api\v1\User;

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


Route::group(['prefix' => 'v1'], function () {
    //login and register routes
    Route::group(['prefix' => 'auth'], function(){
        Route::post('login', Auth\LoginController::class);
        Route::post('register', Auth\RegisterController::class);
    });

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::group(['prefix' => 'tasks'], function(){
            Route::middleware(['role:super-admin','throttle:30,1'])->group(function(){
                Route::post('/', Task\CreateController::class);
                Route::delete('/{uuid}', Task\DeleteController::class);
            });
            Route::get('/{uuid}', Task\ShowController::class);
            Route::get('/', Task\IndexController::class);
            Route::put('/{uuid}', Task\UpdateController::class)->middleware('throttle:30,1');

        });

        Route::group(['prefix' => 'users'], function(){
            Route::middleware(['role:super-admin'])->group(function(){
                Route::post('/', User\CreateController::class);
                Route::get('/{uuid}', User\ShowController::class);
                Route::delete('/{uuid}', User\DeleteController::class);
            });
            Route::get('/', User\IndexController::class);
            Route::put('/{uuid}', User\UpdateController::class)->middleware('throttle:10,1');
        });

        Route::get('list-status', Task\ListStatusController::class);

    });

});
