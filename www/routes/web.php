<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// TODO: リリース後は削除
Route::get('/sample/api', function () {
    return view('api-sample');
});

Route::get('/sample/gc-storage/index', [App\Http\Controllers\SampleGoogleCloudController::class, 'index'])->name('sample.google-cloud.index');
Route::get('/sample/gc-storage/upload-test', [App\Http\Controllers\SampleGoogleCloudController::class, 'uploadTest'])->name('sample.google-cloud.upload-test');
Route::get('/sample/gc-storage/upload-display', [App\Http\Controllers\SampleGoogleCloudController::class, 'uploadDisplay'])->name('sample.google-cloud.upload-display');
Route::post('/sample/gc-storage/upload', [App\Http\Controllers\SampleGoogleCloudController::class, 'upload'])->name('sample.google-cloud.upload');
Route::get('/sample/gc-storage/show', [App\Http\Controllers\SampleGoogleCloudController::class, 'show'])->name('sample.google-cloud.show');
Route::get('/sample/gc-storage/delete', [App\Http\Controllers\SampleGoogleCloudController::class, 'delete'])->name('sample.google-cloud.delete');
