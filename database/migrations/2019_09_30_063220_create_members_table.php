<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('passbook');
            $table->string('name');
            $table->string('fhusband');
            $table->integer('ishusband');
            $table->string('mother');
            $table->integer('gender');
            $table->integer('marital_status');
            $table->integer('religion');
            $table->integer('ethnicity');
            $table->string('guardian');
            $table->string('guardianrelation');
            $table->string('residence_type');
            $table->string('landlord_name');
            $table->string('education');
            $table->string('profession');
            $table->string('dob');
            $table->string('nid');
            $table->date('admission_date');
            $table->date('closing_date');

            $table->string('present_district');
            $table->string('present_upazilla');
            $table->string('present_union');
            $table->string('present_post');
            $table->string('present_village');
            $table->string('present_house');
            $table->string('present_phone');

            $table->string('permanent_district');
            $table->string('permanent_upazilla');
            $table->string('permanent_union');
            $table->string('permanent_post');
            $table->string('permanent_village');
            $table->string('permanent_house');
            $table->string('permanent_phone');

            $table->float('passbook_fee');
            $table->float('admission_fee');
            $table->float('shared_deposit');

            $table->integer('status');
            $table->integer('group_id')->unsigned();
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
        Schema::drop('members');
    }
}
