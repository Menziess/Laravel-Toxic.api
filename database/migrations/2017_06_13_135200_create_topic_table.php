<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {

            // Id's
            $table->increments('id');
            $table->integer('user_id')
				  ->unsigned()
				  ->nullable();

            $table->foreign('user_id')
				  ->references('id')->on('users')
            	  ->onDelete('cascade');

            // Additional Data
            $table->string('slug')->unique();
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
        Schema::dropIfExists('topics');
    }
}
