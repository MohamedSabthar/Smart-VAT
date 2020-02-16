<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleParkTicketingOfficersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_park_ticketing_officers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nic', 12);                                    //nic of ticketin officer
            $table->string('phone', 12);                                  //ticketing_officer's telephone number
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('full_name')->virtualAs('concat_ws(" ",first_name,middle_name,last_name)');  //virutal(derived) attribulte full_name
            $table->string('door_no');
            $table->string('street');
            $table->string('city');
            $table->string('address')->virtualAs('concat(door_no,", ",street,", ",city)');    //derived attribute Addrerss
            $table->bigInteger('employee_id')->unsigned();
            $table->foreign('employee_id')->references('id')->on('users');                    //employee id is FK of users table
            
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
        Schema::dropIfExists('vehicle_park_ticketing_officers');
    }
}
