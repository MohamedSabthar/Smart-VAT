<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubLicenceTaxDuePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('club_licence_tax_due_payments', function (Blueprint $table) {
            $table->bigInteger('payer_id')->unsigned();
            $table->bigInteger('club_id')->unsigned();
            $table->double('due_amount')->default(0);
            $table->primary(['payer_id','club_id']);
            $table->foreign('club_id')->references('id')->on('club_licence_tax_clubs');  //tax payment for club
            $table->foreign('payer_id')->references('id')->on('vat_payers');  //tax payment by a vatpayer
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('club_licence_tax_due_payments');
    }
}
