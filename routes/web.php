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

Route::get('/','PagesController@root')->name('root');

//登录注册生成的路由
Auth::routes();

Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);


Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);

Route::resource('categorys', 'CategorysController', ['only' => [ 'show']]);

Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');
//?代表参数可选，兼容之前填充slug为空的数据
Route::get('topics/{topic}/{slug?}','TopicsController@show')->name('topics.show');


Route::resource('replies', 'RepliesController', ['only' => ['store','destroy']]);

Route::resource('notifications','NotificationsController',['only'=>['index']]);