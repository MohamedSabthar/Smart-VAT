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
        DB::table('users')->insert([
            'name' => 'sabthar',
            'userName'=>'sabthar',
            'email' => 'sabthar@yopmail.com',
            'password' => Hash::make('council@123'),
            'remember_token' => Str::random(10),
            'phone' => '+94772489893',
            'nic' => '9723584563V',
            'role'=>'admin',
  
  'adminId' => 1,          'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('users')->insert([
            'name' => 'faiz',
            'userName'=>'faiz',
            'email' => 'faiz@yopmail.com',
            'password' => Hash::make('council@123'),
            'remember_token' => Str::random(10),
            'phone' => '+94772489893',
            'nic' => '9723584563V',
            'role'=>'employee',
            'adminId' => 1,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Khosalan',
            'userName'=>'Khosalan',
            'email' => 'Khosalan@yopmail.com',
            'password' => Hash::make('council@123'),
            'remember_token' => Str::random(10),
            'phone' => '+94772409893',
            'nic' => '9723599563V',
            'role'=>'employee',
            'adminId' => 1,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'dilushkumar',
            'userName'=>'dilushkumar',
            'email' => 'dilushkumar@yopmail.com',
            'password' => Hash::make('council@123'),
            'remember_token' => Str::random(10),
            'phone' => '+94724589893',
            'nic' => '9623908563V',
            'role'=>'employee',
            'adminId' => 1,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        

        DB::table('users')->insert([
            'name' => 'kasun',
            'userName'=>'kasun',
            'email' => 'kasun@yopmail.com',
            'password' => Hash::make('council@123'),
            'remember_token' => Str::random(10),
            'phone' => '+94708909893',
            'nic' => '9678545373V',
            'role'=>'employee',
            'adminId' => 1,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'suganthan',
            'userName'=>'suganthan',
            'email' => 'suganthan@yopmail.com',
            'password' => Hash::make('council@123'),
            'remember_token' => Str::random(10),
            'phone' => '+94758123463',
            'nic' => '9678245673V',
            'role'=>'employee',
            'adminId' => 1,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

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