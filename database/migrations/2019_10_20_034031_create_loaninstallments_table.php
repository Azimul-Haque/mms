<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoaninstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loaninstallments', function (Blueprint $table) {
            $table->increments('id');
            $table->date('due_date');
            $table->integer('installment_no')->unsigned();
            $table->float('installment_principal');
            $table->float('installment_interest');
            $table->float('installment_total');

            $table->float('paid_principal')->default(0.00);
            $table->float('paid_interest')->default(0.00);
            $table->float('paid_total')->default(0.00);

            $table->float('outstanding_total');

            $table->integer('loan_id')->unsigned();
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
        Schema::drop('loaninstallments');
    }
}
