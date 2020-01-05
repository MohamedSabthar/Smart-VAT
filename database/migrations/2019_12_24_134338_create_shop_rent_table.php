<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopRentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_rent_tax', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('shop_name');                                   // shop/buisness name
            $table->double('key_money');
            $table->double('month_worth');                                  // anual worth of the shop
            $table->string('phone', 12);                                    // user's telephone number
            $table->string('registration_no')->unique();                              // shop/buisness registration no
            $table->string('door_no');
            $table->string('street');
            $table->string('city');
            $table->string('address')->virtualAs('concat(door_no,", ",street,", ",city)');    //derived attribute Addrerss
            $table->bigInteger('payer_id')->unsigned();                         // buisness/Shop owner
            $table->bigInteger('employee_id')->unsigned();
            $table->foreign('payer_id')->references('id')->on('vat_payers');                    //payer id is FK of vat_payers table
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
        Schema::dropIfExists('shop_rent');
    }
}