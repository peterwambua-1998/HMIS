<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('appointment_id');
            $table->string('duration_of_labour');
            $table->date('date_of_delivery');
            
            $table->time('time_of_delivery');
            $table->string('gestation_at_birth');
            $table->string('mode_of_delivery'); //SVD CS BREECH AVD
            $table->string('num_of_babies_delivered');
            $table->string('placenta_complete'); //yes or no BBA
            $table->string('uterotonic_given'); //1=oxytocin 2=Carbetocin 3= None
            $table->string('vaginal_examination'); //1= Normal 2=Episiotomy 3=Vaginal tear 4=FGM 5=Vaginal warts
            $table->string('blood_loss'); // (mls) 
            $table->string('mother_status'); //dead or alive
            $table->string('maternal_deaths_notified')->nullable(); // yes or no
            $table->string('delivery_complications')->nullable();
            $table->string('HIV_status_mother');

            //baby

            $table->string('APGAR_Score');
            $table->string('birth_outcome'); //(LB/FSB/MSB)
            $table->string('birth_weight');
            $table->string('sex');
            $table->string('TEO_given_at_birth'); //yes or no
            $table->string('chlorhexidine_applied_on_cord_stump'); //yes or no
            $table->string('birth_with_deformities'); //yes or no
            $table->string('vitamin_k_given'); //yes or no
            $table->string('VDRL_RPR_results'); //P positive or N negative
            $table->string('HIV_status_baby'); //P positive or N negative
            $table->string('ARV_prophylaxis'); //yes if issued no n/a
            $table->string('CTX_to_mother'); //(Y/N/N/A)
            

            //Partner Involvement
            $table->string('tested_for_hiv')->nullable(); //Y/N/N/A)
            $table->string('hiv_results')->nullable();// postive negative
            $table->string('Counselled_on_infant_feeding')->nullable(); //Y/N
            $table->string('delivery_conducted_by');


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
        Schema::dropIfExists('deliveries');
    }
}
