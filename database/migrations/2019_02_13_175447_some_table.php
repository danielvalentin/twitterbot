<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SomeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('somes', function(Blueprint $table){
			$table->increments('id');
			$table->integer('user_id');
			$table->string('media');
			$table->string('media_id');
			$table->string('token');
			$table->string('tokenSecret')->nullable();
			$table->string('nickname')->nullable();
			$table->string('name')->nullable();
			$table->string('avatar')->nullable();
			$table->integer('followers_count')->default(0);
			$table->integer('friends_count')->default(0);
			$table->string('created')->nullable();
			$table->integer('statuses_count')->default(0);
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
        //
    }
}
