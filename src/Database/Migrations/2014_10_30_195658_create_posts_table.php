<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

       Schema::create('posts', function (Blueprint $table) {
           $table->bigIncrements('id');
           $table->bigInteger('user_id');
           $table->string('title');
           $table->integer('author_id');
           $table->string('slug')->unique();
           $table->integer('position')->nullable();
           $table->enum('status', ['published', 'unpublished','draft'])->default('draft');
           $table->text('images')->nullable();
           $table->text('summary')->nullable();
           $table->text('content')->nullable();
           $table->text('meta_description')->nullable();
           $table->boolean('top')->nullable();
           $table->integer('views')->default(0);
           $table->timestamp('published_at')->useCurrent = true;
           $table->timestamps();
           $table->softDeletes();
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
       Schema::dropIfExists('posts');
       Schema::dropIfExists('post_translations');
       Schema::enableForeignKeyConstraints();


    }
}
