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

Auth::routes(['register' => false]);

Route::middleware('auth')->get('/', 'HomeController@index')->name('home');

Route::middleware('auth')->namespace('Admin')->as('admin.')->group(function () {
    Route::resource('tags', 'TagController');
    Route::resource('posts', 'PostController');

    Route::name('image.')->group(function () {
        Route::post('image/upload-main', 'ImageController@uploadMain')->name('upload-main');
        Route::post('image/delete', 'ImageController@delete')->name('delete');
        Route::post('image/update-alt', 'ImageController@updateAlt')->name('update-alt');
    });

    /*
    Route::name('posts.')->group(function () {
        Route::get('posts', 'PostController@index')->name('index');
        Route::post('posts', 'PostController@store')->name('store');
        Route::get('posts/create', 'PostController@create')->name('create');
        Route::where(['id' => '\d+'])->group(function () {
            Route::get('posts/{id}', 'PostController@show')->name('show');
            Route::get('posts/{id}/edit', 'PostController@edit')->name('edit');
            Route::put('posts/{id}', 'PostController@update')->name('update');
            Route::delete('posts/{id}', 'PostController@destroy')->name('destroy');
        });
    });
    */
});
