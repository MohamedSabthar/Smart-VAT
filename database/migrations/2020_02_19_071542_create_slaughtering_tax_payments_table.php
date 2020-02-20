<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlaughteringTaxPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slaughtering_tax_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('payment');  // payment recived from the client
            $table->integer('animal_count'); //slughtered animals validation have to be sent
            $table->bigInteger('type_id')->unsigned();
            $table->bigInteger('payer_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('slaughtering_type'); // a tax payment has sluaghtering type
            $table->foreign('payer_id')->references('id')->on('vat_payers');    // a tax payment by a vat payer
            $table->foreign('user_id')->references('id')->on('users');          // an employee enteres the record
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
        Schema::dropIfExists('slaughtering_tax_payments');
    }
}
