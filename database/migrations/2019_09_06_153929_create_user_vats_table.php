<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserVatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_vats', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('vat_id')->unsigned();
            $table->primary(['user_id','vat_id']);                      //composite primary key
            $table->foreign('user_id')->references('id')->on('users');  //user_id is a FK of users table
            $table->foreign('vat_id')->references('id')->on('vats');    //vat_id is a FK of vats table
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_vats');
    }
}
