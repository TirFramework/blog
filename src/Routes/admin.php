<?php

// Add web middleware for use Laravel feature
Route::group(['middleware' => 'web'], function () {

    //add admin prefix and middleware for admin area
    Route::group(['prefix' => 'admin', 'middleware' => 'IsAdmin'], function () {
        Route::resource('/post', 'Tir\Blog\Http\Controllers\AdminPostController');
        Route::resource('/postCategory', 'Tir\Blog\Http\Controllers\AdminPostCategoryController');
    });

});