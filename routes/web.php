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

Route::get('',function(){
	return view('layouts.master');
});

Route::get('/', 'BlogController@index')->name('home');

Route::get('category/{slug}','BlogController@category');

Route::get('detail/{slug}','BlogController@show');

Route::post('detail/{slug}','BlogController@store');

Route::get('tag/{slug}','BlogController@tag');

Route::get('search','BlogController@search');

Auth::routes();

Route::get('/admin-home', 'HomeController@admin_home')->name('admin-home');

Route::get('/admin-home/manager-posts/get-list-post','PostController@getListPost')->name('getListPost');

Route::put('/admin-home/manager-posts/{id}/show-update','PostController@update')->name('post.update');

Route::get('/admin-home/manager-posts/show-post/{id}','PostController@show')->name('post.show');

Route::get('/admin-home/manager-posts/edit-post/{id}','PostController@edit')->name('post.edit');

Route::get('/admin-home/manager-posts', 'HomeController@admin_posts')->name('admin-posts');