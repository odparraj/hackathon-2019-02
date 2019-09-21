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


Route::get('notify','SmsController@index');


Route::get('validate/client/{phone}','ValidateController@index');

Route::get('validate/pay-methods/{phone}','ValidateController@payMethods');


Route::get('validate/application-status/{phone}','ValidateController@applicationStatus');

Route::get('validate/pay-value/{phone}','ValidateController@PayValue');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('users', function(Request $request){
    return App\User::create([
        'name'=> $request->name,
        'email'=> $request->email,
        'password'=> Hash::make($request->password),

    ]);
});  


Route::apiResource('ivr-requests', 'IvrRequestController');
