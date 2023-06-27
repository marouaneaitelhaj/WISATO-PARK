<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('readparkzones', 'ParkzoneController@readApi');

Route::post('login', 'Auth\LoginController@login');

Route::post('register', 'Auth\RegisterController@register');


Route::get('readparkzones/{id}', 'ParkzoneController@readApiById');
Route::get('checkiffloorsidestandarexist/{id}/{type}', 'ParkzoneController@checkiffloorsideexist');
Route::get('parkingSlotapi/{parkzpne_id}/{category_id}/{type}/{side}/{floor}', 'ParkingController@parkingSlotapi');




