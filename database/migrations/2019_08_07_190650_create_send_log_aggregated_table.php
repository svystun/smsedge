<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSendLogAggregatedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('send_log_aggregated', function(Blueprint $table)
		{
			$table->increments('agg_id')->unsigned();
			$table->date('agg_date');
			$table->integer('cnt_id')->unsigned()->index('cnt_id');
			$table->integer('usr_id')->unsigned()->index('usr_id');
			$table->integer('success')->unsigned();
			$table->integer('failed')->unsigned();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('send_log_aggregated');
	}

}
