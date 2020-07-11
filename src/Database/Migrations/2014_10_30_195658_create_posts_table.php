<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->integer('author_id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->integer('ordered')->nullable();
            $table->enum('status', ['published', 'unpublished','draft'])->default('draft');
            $table->boolean('top')->nullable();
            $table->integer('views')->default(0);
            $table->timestamp('published_at')->useCurrent = true;
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('post_translations', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->bigInteger('post_id')->unsigned();
            $table->string('locale');
            $table->text('images')->nullable();
            $table->text('summary')->nullable();
            $table->text('content')->nullable();
            $table->text('meta_description')->nullable();

            $table->unique(['post_id', 'locale']);
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');

            DB::statement('SET FOREIGN_KEY_CHECKS = 1');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::dropIfExists('posts');
        Schema::dropIfExists('post_translations');

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
