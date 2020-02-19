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
            'shop_name' => 'wasana bakery',
            'key_money'=>'15750',
            'month_worth' => '2500',
            'phone' => '0776543678',
            'registration_no' =>'46A' ,
            'door_no' => '12',
            'street' => 'Upper Dickson Road',
            'city' => 'Galle',
            'payer_id'   => 1,
            'employee_id' => 1,
           

        ]);
        DB::table('shop_rent_tax')->insert([
            'shop_name' => 'Randika Textile',
            'key_money'=>'19500',
            'month_worth' => '3500',
            'phone' => '0779843678',
            'registration_no' =>'75A' ,
            'door_no' => '13',
            'street' => 'Wakwalla Road',
            'city' => 'Galle',
            'payer_id'   => 2,
            'employee_id' => 1,
           

        ]);
        DB::table('shop_rent_tax')->insert([
            'shop_name' => 'Sarasavi Bookshop',
            'key_money'=>'39000',
            'month_worth' => '7500',
            'phone' => '0776903677',
            'registration_no' =>'19S' ,
            'door_no' => '10',
            'street' => 'Lake Road',
            'city' => 'Galle',
            'payer_id'   => 3,
            'employee_id' => 1,
           

        ]);
        DB::table('shop_rent_tax')->insert([
            'shop_name' => 'sahana food',
            'key_money'=>'15750',
            'month_worth' => '2500',
            'phone' => '0776543600',
            'registration_no' =>'49A' ,
            'door_no' => '18',
            'street' => 'Temple Road',
            'city' => 'Galle',
            'payer_id'   => 4,
            'employee_id' => 1,
           

        ]);
        DB::table('shop_rent_tax')->insert([
            'shop_name' => 'P&G bakery',
            'key_money'=>'80000',
            'month_worth' => '12000',
            'phone' => '0716543648',
            'registration_no' =>'76B' ,
            'door_no' => '10',
            'street' => 'Upper Dickson Road',
            'city' => 'Galle',
            'payer_id'   => 5,
            'employee_id' => 1,
           

        ]);
      
        // DB::table('shop_rent_tax')->insert([
        //     'shop_name' => 'wasana bakery',
        //     'key_money'=>'15750',
        //     'month_worth' => '2500',
        //     'phone' => '0776543678',
        //     'registration_no' =>'46A' ,
        //     'door_no' => '12',
        //     'street' => 'Upper Dickson Road',
        //     'city' => 'Galle',
        //     'payer_id'   => 6,
        //     'employee_id' => 1,
        // ]);

        DB::table('shop_rent_tax')->insert([
            'shop_name' => 'Indra trades',
            'key_money'=>'19000',
            'month_worth' => '5674',
            'phone' => '0726893678',
            'registration_no' =>'43B' ,
            'door_no' => '32',
            'street' => 'karapity road',
            'city' => 'Galle',
            'payer_id'   => 7,
            'employee_id' => 1,
           

        ]);
        DB::table('shop_rent_tax')->insert([
            'shop_name' => 'Nirmani Juice bar',
            'key_money'=>'16890',
            'month_worth' => '1500',
            'phone' => '0726803678',
            'registration_no' =>'81D' ,
            'door_no' => '34',
            'street' => 'Wakwalla Road',
            'city' => 'Galle',
            'payer_id'   => 8,
            'employee_id' => 1,
           

        ]);
    }
}