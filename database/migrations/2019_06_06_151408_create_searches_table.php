<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if(!Schema::hasTable('searches'))
		{
        	Schema::create('searches', function (Blueprint $table) {
            	$table->increments('id');
				$table->integer('some_id');
				$table->string('title');
				$table->text('query');
				$table->string('lastid')->nullable();
				$table->boolean('attention')->default(0);
            	$table->timestamps();
        	});
		}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('queries');
    }
}
