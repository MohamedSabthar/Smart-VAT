<?php

use Illuminate\Database\Seeder;

class ShopRentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shop_rent_tax')->insert([
            'shop_name' => 'punsaraX',
            'key_money'=>'20000000',
            'month_worth' => '1000000',
            'phone' => '0776543678',
            'registration_no' =>' NPH8907' ,
            'door_no' => '89',
            'street' => 'olcot street',
            'city' => 'gale 08',
            'type' => 21,
            'payer_id'   => 1,
            'employee_id' => 1,
           

        ]);
    }
}