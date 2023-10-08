<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRadiologyimagingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('radiologyimagings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('appointment_id');
            $table->unsignedBigInteger('measure_id');
            $table->string('result');
            $table->string('img_url')->nullable();
            $table->string('reasion_for_exam')->nullable();
            $table->string('technique')->nullable();
            $table->string('findings')->nullable();
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
        Schema::dropIfExists('radiologyimagings');
    }
}
