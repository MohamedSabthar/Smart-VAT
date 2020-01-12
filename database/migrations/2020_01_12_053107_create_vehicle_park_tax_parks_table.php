<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleParkTaxParksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_park_tax_parks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('park_type');                                     //Park inside the fort or putside fort  
            $table->bigInteger('officer_id')->unsigned();                     //Ticketing officer assigned to the park
            $table->bigInteger('employee_id')->unsigned();
            $table->foreign('officer_id')->references('id')->on('vehicle_park_ticketing_officers');  //officer id is FK of vehicle_park_ticketing_officers table
            $table->foreign('employee_id')->references('id')->on('users');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_park_tax_parks');
    }
}
