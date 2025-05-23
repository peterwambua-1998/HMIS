<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeasuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('measures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('appointment_id');

            $table->string('measrure_1')->nullable();
            $table->string('measrure_2')->nullable();
            $table->string('measrure_3')->nullable();
            $table->string('measrure_4')->nullable();
            $table->string('measrure_5')->nullable();
            $table->string('measrure_6')->nullable();
            $table->string('measrure_7')->nullable();
            //$table->string('measrure_8')->nullable();
            $table->string('measrure_8')->nullable();
            $table->string('measrure_9')->nullable();
            $table->string('measrure_10')->nullable();
            $table->string('measrure_11')->nullable();
            $table->string('measrure_12')->nullable();
            $table->string('measrure_13')->nullable();
            $table->string('measrure_14')->nullable();
            $table->string('note')->nullable();
            
            

            $table->string('department')->nullable();

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
        Schema::dropIfExists('measures');
    }
}
