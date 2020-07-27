<?php

namespace Tir\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tir\Blog\Entities\Post;

use Illuminate\Routing\Controller;

class PublicPostController extends Controller
{
    
    // TODO : Add scope status
    public function postDetails($slug)
    {

        // return $slug;

        // $post = Post::where( 'slug', 'تست' )->firstOrFail();
        $post = Post::where( 'slug', $slug )->firstOrFail();
        // $post = Post::all();
        // return $post;


        return view(config('crud.front-template').'::public.blog.postDetailes', compact('post'));


    }


}
