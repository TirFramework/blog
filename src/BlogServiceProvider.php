<?php

namespace Tir\Blog;

use Tir\Blog\Models\Post;
use Tir\Blog\Models\User;
use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/Routes/admin.php');
        $this->loadRoutesFrom(__DIR__ . '/Routes/public.php');

        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');

//        $this->loadViewsFrom(__DIR__ . '/Resources/Views', 'post');

        $this->loadTranslationsFrom(__DIR__ . '/Resources/Lang/', 'post');
        $this->loadTranslationsFrom(__DIR__ . '/Resources/Lang/', 'postCategory');

        //Add menu to admin panel
        $this->adminMenu();

    }



    private function adminMenu()
    {
        $menu = resolve('AdminMenu');
        $menu->item('content')->title('post::panel.content')->link('#')->add();
        $menu->item('content.blog')->title('post::panel.blog')->link('#')->add();
        $menu->item('content.blog.category')->title('postCategory::panel.postCategories')->route('postCategory.index')->add();
        $menu->item('content.blog.post')->title('post::panel.posts')->route('post.index')->add();

    }
}
