<?php

namespace Tir\Blog\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\Controller;
use Tir\Blog\Entities\Post;
use Tir\Blog\Entities\Role;

class PublicPostController extends Controller
{

    // TODO : Add scope status
    public function postDetails($slug)
    {

        $post = Post::where('slug', $slug)->with('author')->with('categories')->firstOrFail();

        
        $previous = Post::where('id', '<', $post->id)->orderBy('id','desc')->first();
        $next = Post::where('id', '>', $post->id)->orderBy('id')->first();
        

        $ids = $post->categories()->get()->pluck('id');
        $relatedPosts = Post::whereHas('categories', function (Builder $query) use($ids) {
            return $query->whereIn('post_categories.id', $ids );
        })->where('id','!=', $post->id)->limit(6)->get();


        $lastposts = Post::latest()->limit(5)->get();


        $categories = Role::limit(10)/*->with('children')*/ ->withCount('posts')->get();


        // return $categories;



        return view(config('crud.front-template').'::public.blog.postDetailes', compact('post','previous','next', 'relatedPosts' ,'lastposts' ,'categories'));


    }


    public function category($slug)
    {


        $category = Role::where('slug', $slug)->firstOrFail();

        $posts = $category->posts()->latest()->with('author')->with('categories')->paginate(15);


        $lastposts = Post::latest()->limit(5)->get();


        $categories = Role::limit(10)/*->with('children')*/ ->withCount('posts')->get();

        // return $posts;

        return view(config('crud.front-template').'::public.blog.category', compact('posts','lastposts','categories','category'));

    }


}
