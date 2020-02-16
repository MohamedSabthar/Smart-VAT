<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicenseDuePayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('license_due_payments', function (Blueprint $table) {
            $table->bigInteger('payer_id')->unsigned();
            $table->bigInteger('shop_id')->unsigned();
            $table->double('due_ammount')->default(0);
            $table->primary(['payer_id','shop_id']);
            $table->foreign('shop_id')->references('id')->on('license_tax_shops'); // a tax payment for a buisness
            $table->foreign('payer_id')->references('id')->on('vat_payers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('license_due_payments');
    }
}
