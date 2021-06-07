<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
//

//
//        Schema::create('post_categories', function (Blueprint $table) {
//            $table->bigIncrements('id');
//            $table->integer('user_id');
//            $table->string('slug')->unique();
//            $table->integer('parent_id')->nullable();
//            $table->text('images')->nullable();
//            $table->integer('position')->nullable();
//            $table->enum('status',['draft','published','unpublished'])->default('published');
//            $table->softDeletes();
//        });
//
//        Schema::create('post_category_translations', function (Blueprint $table) {
//
//            $table->bigIncrements('id');
//            $table->bigInteger('post_category_id')->unsigned();
//            $table->string('name');
//            $table->string('locale');
//            $table->text('summary')->nullable();
//            $table->text('description')->nullable();
//            $table->text('meta')->nullable();
//
//            $table->unique(['post_category_id', 'locale']);
//            $table->foreign('post_category_id')->references('id')->on('post_categories')->onDelete('cascade');
//        });
//
//
//        Schema::create('post_post_category', function (Blueprint $table) {
//
//            $table->bigIncrements('id');
//            $table->bigInteger('post_category_id')->unsigned();
//            $table->bigInteger('post_id')->unsigned();
//
//
//            $table->foreign('post_category_id')->references('id')->on('post_categories')->onDelete('cascade');
//            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
//        });

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
        Schema::dropIfExists('post_category_translations');
        Schema::dropIfExists('post_post_category');

        Schema::enableForeignKeyConstraints();

    }
}
