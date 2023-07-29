<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDialysesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dialyses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('appointment_id');
            $table->string('post_bp');
            $table->string('post_weight');
            $table->string('post_temp');
            $table->string('blood_transfusion_done');
            $table->integer('blood_bags');
            $table->date('start_time');
            $table->date('end_time');
            $table->string('doc_start');
            $table->string('doc_end');
            $table->string('dialyzer_type');
            $table->string('bed_no');
            $table->string('machine_no');
            $table->longText('summary');
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
        Schema::dropIfExists('dialyses');
    }
}
