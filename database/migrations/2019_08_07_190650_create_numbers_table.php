<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNumbersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('numbers', function(Blueprint $table)
		{
			$table->increments('num_id')->unsigned();
			$table->integer('cnt_id')->unsigned()->index('cnt_id');
			$table->string('num_number');
			$table->timestamp('num_created')->default(DB::raw('CURRENT_TIMESTAMP'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('numbers');
	}

}
