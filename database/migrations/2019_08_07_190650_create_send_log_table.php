<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSendLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('send_log', function(Blueprint $table)
		{
			$table->increments('log_id')->unsigned();
			$table->integer('usr_id')->unsigned()->index('usr_id');
			$table->integer('num_id')->unsigned()->index('num_id');
			$table->string('log_message');
			$table->enum('log_success', array('1','0'))->nullable()->default('1');
			$table->timestamp('log_created')->default(DB::raw('CURRENT_TIMESTAMP'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('send_log');
	}

}
