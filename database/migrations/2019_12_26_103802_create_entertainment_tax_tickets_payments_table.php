<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntertainmentTaxTicketsPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entertainment_tax_tickets_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('quoted_tickets')->unsigned();   // expected number of tickets
            $table->bigInteger('returned_tickets', 0)->unsigned();   // number of tickets returned
            $table->double('ticket_price');
            $table->double('payment');  // payment recived from the client
            $table->double('returned_payment')->nullable(); // payment returned to client
            $table->string('place_address');    //storing the address of the place where the etertainment event is happening
            $table->bigInteger('type_id')->unsigned();
            $table->bigInteger('payer_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('entertainment_types'); // a tax payment has entertainment type
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
        Schema::dropIfExists('entertainment_tax_payments');
    }
}