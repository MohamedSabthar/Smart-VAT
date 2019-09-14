<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1;$i<=20;$i++) {
            DB::table('users')->insert([
            'name' => Str::random(10),
            'userName'=>Str::random(10),
            'email' => Str::random(10).'@yopmail.com',
            'password' => Hash::make('council@123'),
            'remember_token' => Str::random(10),
            'phone' => '+9477'+(0000000+$i),
            'nic' => '97'+(2600000000+$i),
            'email_verified_at' => now(),
            'adminId' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        }
    }
}