<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSendLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('send_log', function(Blueprint $table)
		{
			$table->foreign('usr_id', 'send_log_ibfk_1')->references('usr_id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('num_id', 'send_log_ibfk_2')->references('num_id')->on('numbers')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('send_log', function(Blueprint $table)
		{
			$table->dropForeign('send_log_ibfk_1');
			$table->dropForeign('send_log_ibfk_2');
		});
	}

}
