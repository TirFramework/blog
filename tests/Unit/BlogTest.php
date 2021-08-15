<?php

namespace Test\Unit;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use Tests\TestCase;

class BlogTest extends TestCase
{
    use WithoutMiddleware;

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
        $response = $this->get('/api/v1/admin/post/');
        $response->assertStatus(200)
            ->dump();
    }

    public function test_post_data_request()
    {
        $response = $this->get('/api/v1/admin/post/data/');
        $response->assertStatus(200);
    }

    public function test_post_create_request()
    {
        $response = $this->get('/api/v1/admin/post/create/');
        $response->assertStatus(200);
    }

    public function test_post_store_request()
    {
        $response = $this->post('/api/v1/admin/post/',
            [
                'title'            => 'Test Post 1',
                'slug'             => 'test post 1',
                'post_category_id' => '1',
                'author_id'        => '1',
                'description'      => 'this is test description',
                'summary'          => 'this is test summary',
                'status'            => '0'


            ]
        );
        $response->assertStatus(200)
            ->seeJson([
                'created' => true,
            ]);
    }
}
