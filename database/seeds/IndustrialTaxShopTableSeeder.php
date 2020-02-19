<?php

use Illuminate\Database\Seeder;

class IndustrialTaxShopTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('industrial_tax_shops')->insert([
            'shop_name' => 'Southern Fashions industrial',
            'anual_worth' => '10000',
             'phone' => '0916543678',
             'registration_no' =>' NPH8907' ,
             'door_no' => '89',
             'street' => 'olcot street',
             'city' => 'galle 08',
             'type' => 21,
             'payer_id'   => 1,
            'employee_id' => 1,
            
          ]);
  
        DB::table('industrial_tax_shops')->insert([
             'shop_name' => 'Detroit Coil Co.',
             'anual_worth' => '15000',
              'phone' => '0916534578',
              'registration_no' =>' NPH907' ,
              'door_no' => '9',
              'street' => 'dickson street',
              'city' => 'galle 07',
              'type' => 80,
              'payer_id'   => 1,
             'employee_id' => 2,
             
           ]);
  
        DB::table('industrial_tax_shops')->insert([
             'shop_name' => 'Demodara Sea Villa',
             'anual_worth' => '2300000',
              'phone' => '0776534678',
              'registration_no' =>' NPH407' ,
              'door_no' => '9',
              'street' => 'Thalagaha road',
              'city' => 'galle 10',
              'type' => 100,
              'payer_id'   => 2,
             'employee_id' => 2,
             
           ]);
  
        DB::table('industrial_tax_shops')->insert([
             'shop_name' => 'Door Works',
             'anual_worth' => '1650000',
              'phone' => '0776984678',
              'registration_no' =>' NPG608' ,
              'door_no' => '99',
              'street' => 'upperdickson street',
              'city' => 'gale 02',
              'type' => 30,
              'payer_id'   => 2,
             'employee_id' => 1,
         ]);
        DB::table('industrial_tax_shops')->insert([
               'shop_name' => 'Mihindhu Bhavan',
               'anual_worth' => '1650000',
                'phone' => '0776984678',
                'registration_no' =>' NPG609' ,
                'door_no' => '99',
                'street' => 'upperdickson street',
                'city' => 'gale 02',
                'type' => 30,
                'payer_id'   => 2,
               'employee_id' => 1,
             ]);
  
        DB::table('industrial_tax_shops')->insert([
                 'shop_name' => 'Inland Industrial',
                 'anual_worth' => '1650000',
                  'phone' => '0776984678',
                  'registration_no' =>' NPG604' ,
                  'door_no' => '99',
                  'street' => 'upperdickson street',
                  'city' => 'gale 02',
                  'type' => 30,
                  'payer_id'   => 2,
                 'employee_id' => 1, ]);
  
  
        DB::table('industrial_tax_shops')->insert([
                   'shop_name' => 'Pak Rite',
                   'anual_worth' => '1450000',
                    'phone' => '0916983678',
                    'registration_no' =>' NPG6HG' ,
                    'door_no' => '145',
                    'street' => 'Prince Street',
                    'city' => 'galle 09',
                    'type' => 30,
                    'payer_id'   => 5,
                   'employee_id' => 5,
                 ]);
  
  
        DB::table('industrial_tax_shops')->insert([
                   'shop_name' => 'Thatcher Company',
                   'anual_worth' => '20000',
                    'phone' => '0776984676',
                    'registration_no' =>' NPG605' ,
                    'door_no' => '99',
                    'street' => 'Galle-Colombo Main Road',
                    'city' => 'Galle Town',
                    'type' => 30,
                    'payer_id'   => 10,
                   'employee_id' => 1,
                 ]);
                 
        DB::table('industrial_tax_shops')->insert([
                   'shop_name' => 'Trinity Indutries',
                   'anual_worth' => '1240000',
                    'phone' => '0916984676',
                    'registration_no' =>' ABG605' ,
                    'door_no' => '99',
                    'street' => 'Light House Street',
                    'city' => 'Galle Fort',
                    'type' => 30,
                    'payer_id'   => 13,
                   'employee_id' => 1,
                 ]);
    }
}