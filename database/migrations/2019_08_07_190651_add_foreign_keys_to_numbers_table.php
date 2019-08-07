<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToNumbersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('numbers', function(Blueprint $table)
		{
			$table->foreign('cnt_id', 'numbers_ibfk_1')->references('cnt_id')->on('countries')->onUpdate('RESTRICT')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('numbers', function(Blueprint $table)
		{
			$table->dropForeign('numbers_ibfk_1');
		});
	}

}
