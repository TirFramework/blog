<?php

namespace Tir\Blog\Http\Controllers;

use Tir\Blog\Entities\Post;
use Tir\Crud\Controllers\CrudController;

class AdminPostController extends CrudController
{
    protected function setModel(): string
    {
        return Post::Class;
    }
}
