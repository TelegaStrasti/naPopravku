<?php

use App\Http\Controllers\API\FileController;
use App\Http\Controllers\API\FolderController;
use App\Http\Controllers\API\PassportAuthController;
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
Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('get-user', [PassportAuthController::class, 'userInfo']);
    Route::resource('folders', FolderController::class);
    Route::post('folders/{folder}/upload', [FileController::class, 'upload']);
    Route::delete('file/delete/{file}', [FileController::class, 'delete']);
    Route::get('file/send/{file}', [FileController::class, 'sendFile']);
    Route::get('disk-size', [FileController::class, 'diskSize']);

});

