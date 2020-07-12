<?php

namespace Tir\Blog\Http\Controllers;

use Tir\Blog\Entities\PostCategory;
use Tir\Crud\Controllers\CrudController;

class AdminPostCategoryController extends CrudController
{
    protected $model = PostCategory::Class;
}
