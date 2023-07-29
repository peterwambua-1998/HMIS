<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDialysisMeasuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dialysis_measures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('appointment_id');
            $table->string('pre_bp');
            $table->string('pre_weight');
            $table->string('pre_temp');
            $table->string('renal_failure');
            $table->string('blood_group');
            $table->dateTime('start_time');
            $table->string('doc_incharge');
            $table->string('approved_by');
            $table->string('diagnosis');
            $table->string('note');
            $table->timestamps();


            $table->foreign('patient_id')->references('id')->on('patients');
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
        Schema::dropIfExists('dialysis_measures');
    }
}
