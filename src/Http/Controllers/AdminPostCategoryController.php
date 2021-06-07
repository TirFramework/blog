<?php

namespace Tir\Blog\Http\Controllers;


use Tir\Blog\Entities\PostCategory;
use Tir\Blog\Entities\PostCategoryScaffold;
use Tir\Crud\Controllers\CrudController;

class AdminPostCategoryController extends CrudController
{

    protected function setModel(): string
    {
        return PostCategory::Class;
    }
}
