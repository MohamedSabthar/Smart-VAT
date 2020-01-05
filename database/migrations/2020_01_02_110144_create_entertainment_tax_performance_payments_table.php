<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntertainmentTaxPerformancePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entertainment_tax_performance_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('days')->unsigned();   // payment for number of days
            $table->double('payment');  // payment recived from the client
            $table->string('place_address');    //storing the address of the place where the etertainment event is happening
            $table->bigInteger('type_id')->unsigned();
            $table->bigInteger('payer_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('entertainment_performance_types'); // a tax payment has entertainment_performance_types type
            $table->foreign('payer_id')->references('id')->on('vat_payers');    // a tax payment by a vat payer
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
        Schema::dropIfExists('entertainment_tax_performance_payments');
    }
}
