<?php

namespace Test\Unit;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Tir\Blog\Entities\Post;

class BlogTest extends TestCase
{
//    use WithoutMiddleware;
//    use RefreshDatabase;


    /**
     * A basic unit test example.
     *
     * @return void
     */

    protected function setUp(): void
    {

        parent::setUp();

    }


    public function test_post_index_request()
    {
        $response = $this->get('/api/v1/admin/post/?api_token=a');
        $response->assertStatus(200)
            ->dump();
    }

    public function test_post_data_request()
    {
        $response = $this->get('/api/v1/admin/post/data/?api_token=a');
        $response->assertStatus(200);
    }

    public function test_post_create_request()
    {
        $response = $this->get('/api/v1/admin/post/create/?api_token=a');
        $response->assertStatus(200);
    }

    public function test_post_store_request()
    {
        $response = $this->post('/api/v1/admin/post/?api_token=a',
            [
                'title'            => 'Test Post 1',
                'user_id'           => '1',
                'slug'             => 'test post 1',
                'post_category_id' => '1',
                'author_id'        => '1',
                'description'      => 'this is test description',
                'summary'          => 'this is test summary',
                'status'            => '0'


            ]
        );
        $response->assertStatus(200)
            ->assertJson([
                'created' => true,
            ]);
    }

    public function test_post_update_request()
    {
        $response = $this->put('/api/v1/admin/post/1/?api_token=a',
            [
                'title'            => 'Test Post 1 edited',
                'user_id'           => '1',
                'slug'             => 'test post 1',
                'post_category_id' => '1',
                'author_id'        => '1',
                'description'      => 'this is test description',
                'summary'          => 'this is test summary',
                'status'            => '0'


            ]
        );
        $response->assertStatus(200)
            ->assertJson([
                'updated' => true,
            ]);
        $post = Post::find(1);
        $this->assertTrue($post->title == 'Test Post 1 edited');
    }
}
