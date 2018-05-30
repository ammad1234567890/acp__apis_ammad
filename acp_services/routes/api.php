<?php

use Illuminate\Http\Request;

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

Route::post('user/login','UserAuthController@login');
Route::post('tutor/signup','UserAuthController@tutor_signup');
Route::post('user/email_validation','UserAuthController@user_email_validation');
Route::post('user/email_verification','UserAuthController@email_verification');
Route::post('user/resend_code','UserAuthController@resend_code');