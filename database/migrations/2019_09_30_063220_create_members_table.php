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
            $table->integer('default_program');
            $table->integer('passbook');
            $table->string('name');
            $table->string('fhusband');
            $table->integer('ishusband');
            $table->string('mother');
            $table->string('admission_date');
            $table->string('education');
            $table->string('dob');
            $table->integer('marital_status');
            $table->integer('religion');
            $table->integer('ethnicity');
            $table->string('guardian');
            $table->string('nid');
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
