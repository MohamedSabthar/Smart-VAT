<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLandTaxDuePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('land_tax_due_payments', function (Blueprint $table) {
            $table->bigInteger('payer_id')->unsigned();
            $table->bigInteger('land_id')->unsigned();
            $table->double('due_amount')->default(0);
            $table->primary(['payer_id','land_id']);
            $table->foreign('payer_id')->reference('id')->on('land_taxes');  //tax payment for a land
            $table->foreign('user_id')->reference('id')->on('vat_payers');  //tax payment by a vatpayer

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
        Schema::dropIfExists('land_tax_due_payments');
    }
}
