<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('loanname_id')->unsigned();
            $table->date('disburse_date');
            $table->integer('installment_type');
            $table->integer('installments');
            $table->date('first_installment_date');
            $table->integer('schemename_id')->unsigned();
            $table->float('principal_amount');
            $table->float('service_charge');
            $table->float('down_payment')->default(0.00);
            $table->float('total_disbursed');
            $table->float('total_paid')->default(0.00);
            $table->float('total_outstanding')->default(0.00);

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
        Schema::drop('loans');
    }
}
