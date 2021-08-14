<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();


        Schema::create('post_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('slug')->unique();
            $table->string('title')->unique();
            $table->integer('parent_id')->nullable();
            $table->softDeletes();
        });


       Schema::create('post_post_category', function (Blueprint $table) {

           $table->bigIncrements('id');
           $table->bigInteger('post_category_id')->unsigned();
           $table->bigInteger('post_id')->unsigned();


           $table->foreign('post_category_id')->references('id')->on('post_categories')->onDelete('cascade');
           $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
       });

        Schema::enableForeignKeyConstraints();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('post_categories');
        Schema::dropIfExists('post_post_category');

        Schema::enableForeignKeyConstraints();

    }
}
