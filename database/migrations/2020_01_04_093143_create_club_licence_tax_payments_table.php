<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubLicenceTaxPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('club_licence_tax_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('payment');
            $table->bigInteger('club_id')->unsigned();
            $table->bigInteger('payer_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('club_id')->references('id')->on('club_licence_tax_clubs'); //a tax payment for a club house
            $table->foreign('payer_id')->references('id')->on('vat_payers'); // tax payment by a vat payer
            $table->foreign('user_id')->references('id')->on('users'); //an employee enters the record
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
        Schema::dropIfExists('club_licence_tax_payments');
    }
}
