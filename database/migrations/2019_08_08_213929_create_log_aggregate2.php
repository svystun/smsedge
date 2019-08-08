<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogAggregate2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_log_aggregated2', function (Blueprint $table) {
            $table->bigIncrements('agg_id');
            $table->date('agg_date');
            $table->integer('cnt_id')->unsigned()->index('cnt_id');
            $table->integer('cnt_success')->unsigned();
            $table->integer('cnt_failed')->unsigned();
            $table->integer('usr_id')->unsigned()->index('usr_id');
            $table->integer('usr_success')->unsigned();
            $table->integer('usr_failed')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('send_log_aggregated2');
    }
}
