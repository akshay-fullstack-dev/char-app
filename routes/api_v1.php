<?php

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
// register the user 
Route::post("register", "API\UserController@create");
Route::post("login", "API\UserController@login");
Route::post('forgot-password', 'API\UserController@forgotPassword');
Route::post('web-register', 'API\UserController@webUserRegister');

Route::middleware('auth:api', 'trialCheck')->group(function () {
    Route::post('logout', "API\UserController@logout");
    Route::post('change-password', 'API\UserController@changePassword');
    Route::post('check-activation', 'API\UserController@checkActivation');
    Route::post('purchase-subscription', 'API\UserPackageController@purchaseSubscription');
});
