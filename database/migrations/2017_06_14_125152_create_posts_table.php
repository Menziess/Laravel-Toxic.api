<?php

use Illuminate\Support\Facades\Schema;
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
        Schema::create('posts', function (Blueprint $table) {

            // Id's
            $table->increments('id');
            $table->integer('user_id')
				  ->unsigned()
				  ->nullable();
            $table->integer('topic_id')
				  ->unsigned()
				  ->nullable();
            $table->integer('post_id')
				  ->unsigned()
				  ->nullable();
            $table->integer('repost_id')
				  ->unsigned()
				  ->nullable();
            $table->integer('resource_id')
				  ->unsigned()
				  ->nullable();

            $table->foreign('user_id')
				  ->references('id')->on('users')
            	  ->onDelete('cascade');
            $table->foreign('topic_id')
				  ->references('id')->on('topics')
            	  ->onDelete('cascade');
            $table->foreign('post_id')
				  ->references('id')->on('posts')
            	  ->onDelete('cascade');
			$table->foreign('resource_id')
				  ->references('id')
				  ->on('resources')
				  ->onDelete('set null');

            // Content
            $table->string('attachment');
            $table->string('subject');
            $table->text('text')
                ->nullable();
            $table->mediumText('drawing')
                ->nullable();
            $table->string('url')
                ->nullable();

            // Additional Data
            $table->string('slug');
            $table->text('data')->nullable();

            // Timestamps & Tokens
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
