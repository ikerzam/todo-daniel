<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
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

Route::controller(AuthController::class)->group(function(){
    Route::post("/login", 'login');
    Route::post("/register", 'register');
    Route::post("/logout", 'logout');
});


Route::controller(TodoController::class)->group(function(){
    Route::middleware('auth:sanctum')->get("/todos", 'index');
    Route::middleware('auth:sanctum')->post("/todos", 'store');
    Route::middleware('auth:sanctum')->put("/todos/{todo}", 'update');
    Route::middleware('auth:sanctum')->delete("/todos/{todo}", 'destroy');
});
