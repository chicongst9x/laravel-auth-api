<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api\V1', 'prefix' => 'v1'], function(){
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@authenticate');
    Route::get('verify-email', 'AuthController@verifyRegisteredMail');

    Route::group(['middleware' => ['jwt.verify']], function() {
        Route::post('logout', 'AuthController@logout');
    });
});
