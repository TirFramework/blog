<?php

namespace Tir\Blog;

use Illuminate\Support\ServiceProvider;
use Tir\Blog\Providers\SeedServiceProvider;
use Tir\Crud\Support\Module\Module;
use Tir\Crud\Support\Module\Modules;

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
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');


        $this->loadRoutesFrom(__DIR__ . '/Routes/admin.php');
        $this->loadRoutesFrom(__DIR__ . '/Routes/public.php');


        $this->loadTranslationsFrom(__DIR__ . '/Resources/Lang/', 'post');
        $this->loadTranslationsFrom(__DIR__ . '/Resources/Lang/', 'postCategory');

        $this->app->register(SeedServiceProvider::class);

        //Add menu to admin panel
        $this->adminMenu();

        $this->registerModule();


    }


    private function adminMenu()
    {
        $menu = resolve('AdminMenu');
        $menu->item('content')->title('post::panel.content')->link('#')->add();
        $menu->item('content.blog')->title('post::panel.blog')->link('#')->add();
        $menu->item('content.blog.category')->title('postCategory::panel.postCategories')->route('admin.postCategory.index')->add();
        $menu->item('content.blog.post')->title('post::panel.posts')->route('admin.post.index')->add();
    }

    private function registerModule()
    {
        $category = new Module();
        $category->setName('postCategory');
        $category->enable();
        Modules::init()->register($category);
    }


}
