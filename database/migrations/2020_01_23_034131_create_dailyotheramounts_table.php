<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyotheramountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dailyotheramounts', function (Blueprint $table) {
            $table->increments('id');
            $table->date('due_date');
            $table->float('cashinhand')->default(0.00);
            $table->float('collentionothers')->default(0.00);
            $table->float('disburseothers')->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dailyotheramounts');
    }
}
