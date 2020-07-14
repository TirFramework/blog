<?php

namespace Tir\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tir\Blog\Entities\Post;
use Tir\Crud\Controllers\CrudController;

class AdminPostController extends CrudController
{
    protected $model = Post::Class;

}
