<?php

namespace Tir\Profile\Http\Controllers;

use Tir\Blog\Entities\Post;
use Tir\Crud\Controllers\CrudController;

class AdminPostController extends CrudController
{
    protected $model = Post::Class;

}
