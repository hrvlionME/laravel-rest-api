<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FilesController;
use App\Http\Controllers\Api\ProjectsController;
use App\Http\Controllers\Api\TasksController;
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

Route::post('/authenticate', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function(){
    Route::apiResource('projects', ProjectsController::class);
    Route::apiResource('tasks', TasksController::class)->except(['index','show']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/upload', [FilesController::class, 'store']);
});