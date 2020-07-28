<?php

// Add web middleware for use Laravel feature
Route::group(['middleware' => 'web'], function () {

    //add admin prefix and middleware for admin area
        Route::get('/post/{slug}', 'Tir\Blog\Http\Controllers\PublicPostController@postDetails')->name('post.details');
        Route::get('/category/{slug}', 'Tir\Blog\Http\Controllers\PublicPostController@category')->name('post.category');

});