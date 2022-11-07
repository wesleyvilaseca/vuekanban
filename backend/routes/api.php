<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\BoardController;
use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\Api\ProjectController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'v1',
    'namespace' => 'Api'
], function () {

    // Route::post('/auth/register', [RegisterController::class, 'store']);
    Route::post('/auth/token', [AuthController::class, 'auth']);

    Route::group([
        'middleware' => ['auth:sanctum']
    ], function () {
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        /**
         * projects
         */
        Route::get('/projects', [ProjectController::class, 'index']);
        Route::post('/project', [ProjectController::class, 'store']);
        Route::post('/project/{id}/edit', [ProjectController::class, 'update']);
        Route::post('/project/{id}/delete', [ProjectController::class, 'delete']);

        /**
         * board
         */
        Route::post('/board', [BoardController::class, 'store']);
        Route::get('/board/{id}', [BoardController::class, 'getByProject']);
        Route::post('/board/{id}/edit', [BoardController::class, 'update']);
        Route::post('/board/{id}/delete', [BoardController::class, 'delete']);

        /**
         * cards
         */
        Route::post('/card', [CardController::class, 'store']);
        Route::post('/card/{id}/edit', [CardController::class, 'update']);
        Route::post('/card/{id}/delete', [CardController::class, 'delete']);
    });
});