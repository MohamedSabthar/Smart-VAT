<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');                                    //primary key
            $table->string('email')->unique();                              //email used for account varification and password rest
            $table->string('password');                                     //password
            $table->string('name');                                         //user's original name
            $table->string('nic', 12);                                      //nic of user
            $table->string('phone', 12);                                    //user's telephone number
            $table->string('userName')->unique();                           //user-name for login purpose
            $table->string('role')->default('employee');                    //employee role admin or employee
            $table->bigInteger('adminId')->unsigned()->nullable();          //which admin added the employee?
            $table->timestamp('email_verified_at')->nullable();             //is email verified time
            $table->rememberToken();                                        //remembertoken for remember while the login
            $table->timestamps();                                           //account created and status updated time
            $table->foreign('adminId')->references('id')->on('users');      //admin id is FK of users table
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}