<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSendLogAggregatedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('send_log_aggregated', function(Blueprint $table)
		{
			$table->foreign('cnt_id', 'send_log_aggregated_ibfk_2')->references('cnt_id')->on('countries')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('usr_id', 'send_log_aggregated_ibfk_3')->references('usr_id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('send_log_aggregated', function(Blueprint $table)
		{
			$table->dropForeign('send_log_aggregated_ibfk_2');
			$table->dropForeign('send_log_aggregated_ibfk_3');
		});
	}

}
