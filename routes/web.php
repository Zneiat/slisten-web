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
    Route::get('/', 'UserController@index')->name('user_home');
    Route::get('/write', 'UserController@showWriteForm')->name('user_write');
    Route::post('/write', 'UserController@write');
    Route::post('/sendMessage', 'UserController@sendMessage')->name('send_message');
    Route::get('/post-view/{postId}', 'UserController@postView')->name('post_view')->where(['postId' => '[0-9]+']);
});