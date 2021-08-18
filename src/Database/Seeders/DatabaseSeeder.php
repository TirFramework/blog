<?php

namespace Tir\Blog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('post_categories')->insert([
            'id'        => '2',
            'user_id'   => '1',
            'title'     => 'test',
            'slug'      => 'test',
            'parent_id' => '2'
        ]);

    }
}
