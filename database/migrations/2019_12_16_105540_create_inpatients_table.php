<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInpatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inpatients', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->timestamps();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('appointment_id');
            $table->string('patient_name');
            $table->integer('patient_reg_no');
            $table->integer('patientidnumber')->nullable();
            //$table->increments('appointment_id');
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->char('discharged',4)->default('NO'); // YES | NO
            $table->unsignedBigInteger('ward_id');
            $table->foreign('ward_id')->references('id')->on('wards');
            $table->integer('bed_no')->nullable();
            $table->date('discharged_date')->nullable();
            $table->string('description')->nullable();
            $table->string('discharged_officer')->nullable();
            $table->string('patient_inventory')->nullable();
            
            // $table->string('incharge_doctor');
            $table->string('house_doctor')->nullable();
            $table->string('approved_doctor');
            $table->string('disease')->nullable();
            $table->integer('duration')->nullable();
            $table->string('condition')->nullable();
            $table->string('certified_officer');
            $table->string('discharge_status');
            $table->string('referred_to')->nullable();
            $table->string('if_diseased')->nullable();
            $table->string('if_toattendclinic')->nullable();


            //for maternity
            $table->string('gravidae')->nullable();
            $table->integer('num_of_anc_visits')->nullable();
            $table->date('last_menstrual_period')->nullable();
            $table->date('expected_date_of_delivery')->nullable();


            $table->foreign('appointment_id')->references('id')->on('appointments');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inpatients');
    }
}
