<?php

use Illuminate\Database\Seeder;

class BuisnessTaxShopsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('buisness_tax_shops')->insert([
           'shop_name' => 'punsaraX',
           'anual_worth' => '1000000',
            'phone' => '0776543678',
            'registration_no' =>' NPH8907' ,
            'door_no' => '89',
            'street' => 'olcot street',
            'city' => 'gale 08',
            'payer_id'   => 1,
           'employee_id' => 1,
           
         ]);

        DB::table('buisness_tax_shops')->insert([
            'shop_name' => 'punsaray',
            'anual_worth' => '1500000',
             'phone' => '0776534678',
             'registration_no' =>' NPH907' ,
             'door_no' => '9',
             'street' => 'dickson street',
             'city' => 'gale 07',
             'payer_id'   => 1,
            'employee_id' => 2,
            
          ]);

        DB::table('buisness_tax_shops')->insert([
            'shop_name' => 'punsaray',
            'anual_worth' => '1500000',
             'phone' => '0776534678',
             'registration_no' =>' NPH907' ,
             'door_no' => '9',
             'street' => 'dickson street',
             'city' => 'gale 07',
             'payer_id'   => 1,
            'employee_id' => 2,
            
          ]);

        DB::table('buisness_tax_shops')->insert([
            'shop_name' => 'tharuX',
            'anual_worth' => '1600000',
             'phone' => '0776984678',
             'registration_no' =>' NPG607' ,
             'door_no' => '99',
             'street' => 'upperdickson street',
             'city' => 'gale 02',
             'payer_id'   => 2,
            'employee_id' => 1,
            
          ]);
    }
}