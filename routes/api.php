<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserAuthController;

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

Route::post('login', 'App\Http\Controllers\API\UserAuthController@login');
Route::post('register', 'App\Http\Controllers\API\UserAuthController@register');
Route::post('restore', 'App\Http\Controllers\API\UserAuthController@forget');
Route::post('reset', 'App\Http\Controllers\API\UserAuthController@resetPassword');
Route::get('aktywacja/{token}', 'App\Http\Controllers\API\UserAuthController@aktywacja');



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
     
    Route::post('setPostac',  'App\Http\Controllers\API\GraczController@setPostac');
    Route::post('getMap', 'App\Http\Controllers\API\MapController@getMap');

});