<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSavinginstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('savinginstallments', function (Blueprint $table) {
            $table->increments('id');
            $table->date('due_date');
            $table->float('amount')->default(0.00);
            $table->float('withdraw')->default(0.00);
            $table->float('balance')->default(0.00);
            $table->integer('member_id')->unsigned();
            $table->integer('savingname_id')->unsigned();
            $table->integer('saving_id')->unsigned();
            $table->integer('user_id')->unsigned();
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
        Schema::drop('savinginstallments');
    }
}
