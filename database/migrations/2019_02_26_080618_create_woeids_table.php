<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWoeidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if(!Schema::hasTable('woeids'))
		{
        	Schema::create('woeids', function (Blueprint $table) {
            	$table->increments('id');
				$table->string('name');
				$table->integer('placecode');
				$table->string('placename');
				$table->string('url');
				$table->integer('parentid')->null();
				$table->string('country')->null();
				$table->integer('woeid');
				$table->string('countrycode')->null();
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
        Schema::dropIfExists('woeids');
    }
}
