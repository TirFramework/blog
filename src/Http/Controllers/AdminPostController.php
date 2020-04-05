<?php

namespace Tir\Profile\Http\Controllers;


use Tir\Blog\Models\Post;
use Tir\Crud\Http\Controllers\CrudController;

class AdminProfileController extends CrudController
{
    protected $model = Post::Class;

}
