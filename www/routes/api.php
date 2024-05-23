<?php

use App\Http\Controllers\SampleApiController;
use App\Http\Controllers\ZoomSampleController;
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

Route::get('/sample/guzzle', [SampleApiController::class, 'index']);
// Zoom API
Route::get('/zoom/authorize', [ZoomSampleController::class, 'auth']);
Route::get('/zoom/create', [ZoomSampleController::class, 'create']);
