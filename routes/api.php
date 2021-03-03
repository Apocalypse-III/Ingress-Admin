<?php

/*
 * 鉴权: middleware(['auth:api'])
 * */

Route::group(['prefix' => 'auth'], function () {
    Route::get('logout', 'AuthController@logout')->middleware(['auth:api']);
    Route::get('userinfo', 'AuthController@userinfo')->middleware(['auth:api']);
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
});
