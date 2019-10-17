<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSavingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('savings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('savingname_id')->unsigned();
            $table->date('opening_date');
            $table->integer('meeting_day');
            $table->integer('installment_type');
            $table->integer('minimum_deposit');
            $table->float('total_amount')->defaul(0.00);
            $table->float('late_fee')->defaul(0.00);
            $table->float('interest')->defaul(0.00);
            $table->date('closing_date');
            $table->integer('status');
            $table->integer('member_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('savings');
    }
}
