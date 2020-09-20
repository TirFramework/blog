<?php

// Add web middleware for use Laravel feature
Route::middleware(['web','IsAdmin'])->group(function () {

    //add admin prefix and middleware for admin area
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('/post', 'Tir\Blog\Http\Controllers\AdminPostController');
        Route::resource('/postCategory', 'Tir\Blog\Http\Controllers\AdminPostCategoryController');
    });
});