<?php

use Illuminate\Support\Facades\Route;
use Tir\Blog\Http\Controllers\AdminPostCategoryController;
use Tir\Blog\Http\Controllers\AdminPostController;

// Add web middleware for use Laravel feature

Route::group(['middleware' => 'web'], function () {

    //add admin prefix and middleware for admin area
    Route::group(['prefix' => 'admin', 'middleware' => 'IsAdmin'], function () {
        Route::resource('/post', AdminPostController::class, ['names' => 'admin.post']);
        Route::resource('/postCategory', AdminPostCategoryController::class, ['names' => 'admin.postCategory']);
    });

});