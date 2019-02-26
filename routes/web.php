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

Route::get('like/{slug}','BlogController@like_posts');

Route::get('dislike/{slug}','BlogController@dislike_posts');

Route::prefix('/admin')->group(function(){

	Auth::routes();

	Route::middleware('auth')->group(function(){

		Route::get('/home', 'HomeController@admin_home')->name('admin-home');

		// Route::get('/home1', function(){
		// 	if (Auth::user()->permission == 0) {
		// 		$app = app();
		// 		$controller = $app->make('\App\Http\Controllers\HomeController');
		// 		return $controller->callAction('admin_home', $parameters = array());
		// 	}
		// })->name('admin-home');

		Route::prefix('/manager-posts')->group(function(){

			// $app = app();
			// $controller = $app->make('\App\Http\Controllers\HomeController');

			Route::get('', 'PostController@admin_posts')->name('admin-posts');

			Route::get('/create', 'PostController@create')->name('admin-posts-create');

			Route::post('/store', 'PostController@store')->name('admin-posts-store');

			Route::get('/detail/{id}', 'PostController@show')->name('admin-posts-show');

			Route::get('/edit/{id}', 'PostController@edit')->name('admin-posts-edit');

			Route::patch('/edit/{id}/update','PostController@update')->name('admin-posts-update');

			Route::put('/{id}/delete','PostController@delete')->name('admin-posts-delete');

		});

		Route::prefix('/manager-delete-posts')->group(function(){

			Route::get('', 'PostController@admin_delete_posts')->name('admin-delete-posts');

			Route::get('/detail/{id}', 'PostController@delete_post_show')->name('admin-delete-posts-show');

			Route::put('/{id}/upback', 'PostController@delete_post_upback')->name('admin-delete-posts-upback');

			Route::delete('/{id}/real_delete', 'PostController@delete_post_real_delete')->name('admin-delete-posts-realdelete');

		});

		Route::prefix('/manager-trash-posts')->group(function(){

			Route::get('', 'PostController@admin_trash_posts')->name('admin-trash-posts');

			Route::get('/detail/{id}', 'PostController@trash_post_show')->name('admin-trash-posts-show');

			Route::get('/edit/{id}', 'PostController@trash_post_edit')->name('admin-trash-posts-edit');

			Route::patch('/edit/{id}/update','PostController@trash_post_update')->name('admin-trash-posts-update');

			Route::put('/{id}/publish', 'PostController@trash_post_publish')->name('admin-trash-posts-publish');

			Route::delete('/{id}/real_delete', 'PostController@trash_post_real_delete')->name('admin-trash-posts-realdelete');

		});

		Route::prefix('/manager-tags')->group(function(){

			Route::get('', 'TagController@index')->name('admin-tags');

			Route::post('/store', 'TagController@store')->name('admin-tags-store');

			Route::get('/detail/{id}', 'TagController@show')->name('admin-tags-show');

			Route::get('/edit/{id}', 'TagController@edit')->name('admin-tags-edit');

			Route::put('/edit/{id}/update','TagController@update')->name('admin-tags-update');

			Route::delete('/{id}/delete', 'TagController@destroy')->name('admin-tags-destroy');
		});

		Route::prefix('/manager-categories')->group(function(){

			Route::get('', 'CategoryController@index')->name('admin-categories');

			Route::post('/store', 'CategoryController@store')->name('admin-categories-store');

			Route::get('/detail/{id}', 'CategoryController@show')->name('admin-categories-show');

			Route::get('/edit/{id}', 'CategoryController@edit')->name('admin-categories-edit');

			Route::put('/edit/{id}/update','CategoryController@update')->name('admin-categories-update');

			Route::delete('/{id}/delete', 'CategoryController@destroy')->name('admin-categories-destroy');
		});

	});
});