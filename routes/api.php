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


Route::get('validate/client/cellphone/{phone}','ValidateController@cellphone');

Route::get('validate/client/identification','ValidateController@identification');

Route::get('validate/pay-methods','ValidateController@payMethods');

Route::get('validate/application-status','ValidateController@applicationStatus');

Route::get('validate/pay-value','ValidateController@PayValue');

Route::get('validate/code-contract','ValidateController@contrctCode');

Route::get('validate/restore-pin','ValidateController@restorePin');

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
