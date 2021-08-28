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
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('author_id');
            $table->string('title', 250);
            $table->string('slug', 250)->unique();
            $table->text('description');
            $table->text('summary');
            $table->unsignedTinyInteger('status')->default(0);
            $table->text('thumb_image')->nullable();
            $table->text('full_image')->nullable();
            $table->string('meta_title', 250)->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->bigInteger('views')->default(0);
            $table->timestamp('published_at')->default(now());
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
        Schema::enableForeignKeyConstraints();
    }
}
