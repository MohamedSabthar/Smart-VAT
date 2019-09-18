<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssessmentRangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment_ranges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('start_value');                                          //assessment range starts on this value
            $table->double('end_value');
            $table->bigInteger('vat_id')->unsigned();                                           //assessment range ends on this value
            $table->foreign('vat_id')->references('id')->on('vats');                    //admin id is FK of users table
            // $table->timestamps();                                                //assesment range created and updated time
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assessment_ranges');
    }
}
