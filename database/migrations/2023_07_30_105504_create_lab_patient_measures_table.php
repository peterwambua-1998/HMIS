<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabPatientMeasuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_patient_measures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('measure_id')->nullable();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('appointment_id');
            $table->boolean('paid')->default(0);
            $table->string('note')->nullable();
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
        Schema::dropIfExists('lab_patient_measures');
    }
}
