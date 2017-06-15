<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            // Id's
            $table->increments('id');
            $table->string('api_token', 60)
                ->unique();
            $table->bigInteger('facebook_id')
                ->unsigned()
				->unique()
				->nullable();

            // Name
            $table->string('first_name');
            $table->string('last_name');
            $table->string('slug')->unique();

            // Email & Password
            $table->string('email')
                ->nullable()
                ->unique();
            $table->string('password')
                ->nullable();

            // Additional Data
            $table->string('gender')
				 ->nullable();
			$table->timestamp('date_of_birth')
				->nullable();
			$table->string('latitude')
				->nullable();
			$table->string('longitude')
				->nullable();
            $table->text('data')->nullable();

            // Timestamps & Tokens
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
