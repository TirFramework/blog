<?php

use Illuminate\Support\Facades\Route;
use Tir\Blog\Http\Controllers\AdminPostCategoryController;
use Tir\Blog\Http\Controllers\AdminPostController;

Route::group(['middleware' => 'auth:api', 'prefix' => 'api/v1/admin'], function () {
    Route::resource('/post', AdminPostController::class, ['names' => 'admin.post']);
    Route::resource('/postCategory', AdminPostCategoryController::class, ['names' => 'admin.postCategory']);
});