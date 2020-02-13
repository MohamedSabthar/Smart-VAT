<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleParkTicketPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_park_ticket_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('payment');
            $table->string('vehicle_type'); //amount is paid by cars,lorrys or bicycles etc.
            $table->bigInteger('park_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('park_id')->references('id')->on('vehicle_park_tax_parks'); // a tax payment for a buisness
            $table->foreign('user_id')->references('id')->on('users');          // an employee enteres the record
            
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
        Schema::dropIfExists('vehicle_park_ticket_payments');
    }
}
