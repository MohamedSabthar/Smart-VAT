<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVatPayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vat_payers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email')->unique();
            $table->string('nic', 12);                                      //nic of vat_payer
            $table->string('phone', 12);                                    //vat_payers's telephone number
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('full_name')->virtualAs('concat(first_name," ", middle_name, " ", last_name)');
            $table->string('door_no');
            $table->string('street');
            $table->string('city');
            $table->string('Address')->virtualAs('concat(door_no," ",street," ",city)');


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
        Schema::dropIfExists('vat_payers');
    }
}
