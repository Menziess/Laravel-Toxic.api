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

            // Content
            $table->integer('type');
            $table->string('subject');
            $table->text('text')
                ->nullable();
            $table->text('drawing')
                ->nullable();
            $table->string('url');

            // Additional Data
            $table->text('data')->nullable();

            // Timestamps & Tokens
            $table->softDeletes();
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
