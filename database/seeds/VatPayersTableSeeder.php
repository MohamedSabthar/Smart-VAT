<?php

use Illuminate\Database\Seeder;

class VatPayersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vat_payers')->insert([
         
           'email' => '1@yopmail.com',
            'nic' => '972689768V',
           'phone'=> '0774578398',
           'first_name' => 'punsara',
           'middle_name' => 'chamath',
           'last_name' => 'kariyawasam',
           'door_no'    => '23',
           'street' => 'jaya road',
           'city'   => 'gale 01',
           'employee_id' => 1,
        ]);

        for ($i=1;$i<=20;$i++) {
            DB::table('vat_payers')->insert([
               'email' => Str::random(10).'@yopmail.com',
               'nic' => '98'+(4500000000+$i),
               'phone'=> '+9471'+(0000000+$i),
               'first_name' => Str::random(5),
               'middle_name' => Str::random(5),
               'last_name' => Str::random(5),
               'door_no'    => '14',
               'street' => Str::random(4),
               'city'   => Str::random(4),
               'employee_id' => 2,   

            ]);
        }
    }
}