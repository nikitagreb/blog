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
});
