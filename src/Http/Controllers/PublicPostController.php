<?php

namespace Tir\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tir\Blog\Entities\Post;
use Tir\Blog\Entities\PostCategory;

use Illuminate\Routing\Controller;

class PublicPostController extends Controller
{
    
    // TODO : Add scope status
    public function postDetails($slug)
    {

        // return $slug;

        // $post = Post::where( 'slug', 'تست' )->firstOrFail();
        $post = Post::where( 'slug', $slug )->with('author')->with('categories')->firstOrFail();
        // $post = Post::all();
        
        
        $previous = Post::where('id', '<', $post->id)->orderBy('id','desc')->first();
        $next = Post::where('id', '>', $post->id)->orderBy('id')->first();
        
        // return $post->categories()->firstOrFail()->posts()->get();

        //  return $post->categories()->get()->pluck('id');
        
        $relatedPosts = Post::whereIn('id', $post->categories()->get()->pluck('id'))->where('id','!=',$post->id)->get();
        
        // return $relatedPosts;

        $lastposts = Post::latest()->limit(5)->get();


        $categories = PostCategory::limit(10)/*->with('children')*/->withCount('posts')->get();


        // return $categories;



        return view(config('crud.front-template').'::public.blog.postDetailes', compact('post','previous','next', 'relatedPosts' ,'lastposts' ,'categories'));


    }

    public function category($slug)
    {
        
        $PostCategory = PostCategory::where( 'slug', $slug )->with('posts')->firstOrFail();


        $lastposts = Post::latest()->limit(5)->get();


        $categories = PostCategory::limit(10)/*->with('children')*/->withCount('posts')->get();

        // return $PostCategory;

        return view(config('crud.front-template').'::public.blog.category', compact('PostCategory','lastposts','categories'));


    }


}
