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

        DB::table('vat_payers')->insert([
         
            'email' => '2@yopmail.com',
             'nic' => '972689769V',
            'phone'=> '0774578399',
            'first_name' => 'tharu',
            'middle_name' => 'shi',
            'last_name' => 'samara',
            'door_no'    => '40',
            'street' => 'deen road',
            'city'   => 'gale 02',
            'employee_id' => 2,
         ]);

        DB::table('vat_payers')->insert([
         
            'email' => '3@yopmail.com',
             'nic' => '962689769V',
            'phone'=> '0774543399',
            'first_name' => 'imal',
            'middle_name' => 'sha',
            'last_name' => 'rathnaweera',
            'door_no'    => '50',
            'street' => 'ds road',
            'city'   => 'gale 01',
            'employee_id' => 1,
         ]);

        DB::table('vat_payers')->insert([
            'email' => '4@yopmail.com',
             'nic' => '972689739V',
            'phone'=> '0774548999',
            'first_name' => 'sabthar',
            'last_name' => 'mahroof',
            'door_no'    => '89',
            'street' => 'upper road',
            'city'   => 'gale 89',
            'employee_id' => 2,
         ]);
    }
}