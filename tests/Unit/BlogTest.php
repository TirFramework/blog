<?php

namespace Test\Unit;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Tir\Blog\Entities\Post;
use Tir\Blog\Entities\PostCategory;

class BlogTest extends TestCase
{
    use WithoutMiddleware;

//    use RefreshDatabase;
    private PostCategory $postCategory;
    private Post $post;
    private $user;


    /**
     * A basic unit test example.
     *
     * @return void
     */

    protected function beforeEach(): void
    {
//        Artisan::call()
        $this->user = Auth::loginUsingId(10);
        $this->postCategory = new PostCategory();
        $this->postCategory->scaffold();

        $this->post = new Post();
        $this->post->scaffold();
    }

    public function test_post_category_index_request()
    {

        $this->beforeEach();

        $fields = $this->postCategory->getIndexFields();
        $response = $this->get('/api/v1/admin/postCategory');
        $cols = $response['cols'];

        for ($i = 0; $i < count($fields); ++$i) {
//            echo $fields[$i]->name . '=' . $cols[$i]['fieldName']."\n";
            assert($fields[$i]->name == $cols[$i]['fieldName']);
        }

        $response->assertStatus(200);

    }

    public function test_post_category_data_request()
    {
        $response = $this->get('/api/v1/admin/postCategory/data/');
        $response->assertStatus(200);
    }


    public function test_post_category_create_request()
    {
        $this->beforeEach();

        $fields = $this->postCategory->getCreateFields();

        $response = $this->get('/api/v1/admin/postCategory/create');
        $cols = $response;

        for ($i = 0; $i < count($fields); ++$i) {
            assert($fields[$i]->name == $cols[$i]['name']);
        }

        $response->assertStatus(200);
    }

    public function test_post_category_store_request()
    {
        $this->beforeEach();
        $response = $this->post('/api/v1/admin/postCategory/',
            [
                'title'     => 'Test Post 1',
                'slug'      => 'test post 1',
                'user_id' => $this->user->id,
                'description' => 'test description',
                'parent_id' => '2',
                'status'    => '0',
                'locale'    => 'en'
            ]
        );
        $response->assertStatus(200)
            ->assertJson([
                'created' => true,
            ]);
    }

    public function test_post_category_edit_request()
    {
        $this->beforeEach();

        $fields = $this->postCategory->getEditFields();

        $post = PostCategory::first();

        $response = $this->get('/api/v1/admin/postCategory/'.$post->id.'/edit');
        $cols = $response;

        for ($i = 0; $i < count($fields); ++$i) {
            assert($fields[$i]->name == $cols[$i]['name']);
        }

        $response->assertStatus(200);
    }


    public function test_post_category_update_request()
    {
        $this->beforeEach();
        $postCategory = PostCategory::where('slug','test post 1')->withoutGlobalScope('locale')->first();
        $response = $this->put('/api/v1/admin/postCategory/'.$postCategory->id.'?locale=all',
            [
                'title'     => 'Test Post 1 edited',
                'slug'      => 'test post 1',
                'parent_id' => '2',
                'status'    => 'Published',
                'locale'    => 'en'
            ]
        );

        $response->assertStatus(200)
            ->assertJson([
                'updated' => true,
            ]);

        $postCategory = PostCategory::where('slug','test post 1')->first();

        assert($postCategory->title == 'Test Post 1 edited');
    }




    public function test_post_index_request()
    {

        $this->beforeEach();

        $fields = $this->post->getIndexFields();
        $response = $this->get('/api/v1/admin/post');
        $cols = $response['cols'];

        for ($i = 0; $i < count($fields); ++$i) {
            assert($fields[$i]->name == $cols[$i]['fieldName']);
        }

        $response->assertStatus(200);
    }


    public function test_post_data_request()
    {
        $response = $this->get('/api/v1/admin/post/data/');
        $response->assertStatus(200);
    }



    public function test_post_create_request()
    {
        $this->beforeEach();

        $fields = $this->post->getCreateFields();

        $response = $this->get('/api/v1/admin/post/create');
        $cols = $response;

        for ($i = 0; $i < count($fields); ++$i) {
            assert($fields[$i]->name == $cols[$i]['name']);
        }

        $response->assertStatus(200);
    }



    public function test_post_store_request()
    {
        $this->beforeEach();

        $response = $this->post('/api/v1/admin/post/',
            [
                'title'            => 'Test Post 1',
                'slug'             => 'test post 1',
                'categories' => PostCategory::first()->id,
                'author_id'        => '1',
                'description'      => 'this is test description',
                'summary'          => 'this is test summary',
                'status'           => 'Published',
                'locale'           => 'en'


            ]
        );
        $response->assertStatus(200)
            ->assertJson([
                'created' => true,
            ]);
    }


    public function test_post_edit_request()
    {
        $this->beforeEach();

        $fields = $this->post->getEditFields();

        $post = Post::first();


        $response = $this->get('/api/v1/admin/post/'.$post->id.'/edit');
        $cols = $response;

        for ($i = 0; $i < count($fields); ++$i) {
            assert($fields[$i]->name == $cols[$i]['name']);
        }

        $response->assertStatus(200);
    }



    public function test_post_update_request()
    {
        $this->beforeEach();
        $postCategory = Post::where('slug','test post 1')->withoutGlobalScope('locale')->first();

        $response = $this->put('/api/v1/admin/post/'.$postCategory->id,
            [
                'title'            => 'Test Post 1 edited',
                'slug'             => 'test post 1',
                'categories' => PostCategory::first()->id,
                'author_id'        => '1',
                'description'      => 'this is test description',
                'summary'          => 'this is test summary',
                'status'           => '0',
                'locale'           => 'en'
            ]
        );

        $response->assertStatus(200)
            ->assertJson([
                'updated' => true,
            ]);

        $post = Post::where('slug','test post 1')->first();

        assert($post->title == 'Test Post 1 edited');
    }
}
