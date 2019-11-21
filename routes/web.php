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
        Route::post('image/upload', 'ImageController@uploadImage')->name('upload-image');
        Route::post('image/delete-main', 'ImageController@deleteMain')->name('delete-main');
        Route::post('image/delete-image', 'ImageController@deleteImage')->name('delete-image');
        Route::post('image/update-main-alt', 'ImageController@updateMainAlt')->name('update-main-alt');
        Route::post('image/update-image-alt', 'ImageController@updateImageAlt')->name('update-image-alt');
        Route::post('image/get-images', 'ImageController@getImages')->name('get-images');
    });
});
