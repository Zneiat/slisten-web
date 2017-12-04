<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

// 用户中心
Route::group(['prefix' => '/user'], function () {
    Route::get('/', 'User\UserController@index')->name('user_home');
    Route::get('/write', 'User\UserController@writeForm')->name('user_write');
    Route::get('/post-view/{postId}', 'User\UserController@postView')->name('post_view')->where(['postId' => '[0-9]+']);
});

Route::group(['prefix' => '/api/user'], function () {
    Route::post('/write', 'User\UserApiController@write')->name('api_user_write');
    Route::post('/messageSend', 'User\UserApiController@messageSend')->name('api_user_message_send');
});
